<?php 

namespace Controllers;

use Classes\Email;
use Model\usuario;
use MVC\Router;
use Reflector;

class LoginController{
    public static function login(Router $router){
        $alertas = [];
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new  usuario($_POST);

            $alertas = $auth->validarLogin();

            if(empty($alertas)){
                //Conprobar que exista el usuario
                $usuario = usuario::where('email',$auth->email);
                if($usuario){
                    //Verificar el password
                    if($usuario->comprobarPasswordAndVerificado($auth->password)){
                        //Autenticar el usuario
                        if(!isset($_SESSION)) {
                            session_start();
                        };
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre." ".$usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        //Redireccionamiento
                        if($usuario->admin === "1"){
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        }else{
                            header('Location: /cita');
                        }
                    }
                }else{
                    usuario::setAlerta('error','Usuario no Encontrado');
                }
            }
        
        }

        $alertas = usuario::getAlertas();
        
        $router->render('/auth/login',[
            'alertas' => $alertas
            
        ]);

    }
    public static function logout(){
        session_start();
        $_SESSION = [];
        header('Location: /');
    }
    public static function olvide(Router $router){
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new usuario($_POST);
            $alertas = $auth->validarEmail();

            if(empty($alertas)){
                $usuario = usuario::where('email',$auth->email);
                if($usuario && $usuario->confirmado === "1"){
                    //Generar un token
                    $usuario->crearToken();
                    $usuario->guardar();

                    
                    //Enviar el email
                    $email = new Email($usuario->email,$usuario->nombre,$usuario->token);
                    $email->enviarInstrucciones();
                    
                    //Alerta de exito
                    usuario::setAlerta('exito','Revisa tu email');
                }else{
                    usuario::setAlerta('error','El usuario no existe o no esta confirmado');
                }
            }
        }
        $alertas = usuario::getAlertas();
        
        $router->render('/auth/olvide',[
            'alertas' => $alertas
        ]);
    }

    public static function recuperar(Router $router){
        $alertas = [];
        $error = false;
        $token = s($_GET['token']);


        //Buscar usuario por su token
        $usuario = usuario::where('token', $token);
        if(empty($usuario)){
            usuario::setAlerta('error','Token no Valido');
            $error = true;
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Leer el nuevo password y guardarlo
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();

            if(empty($alertas)) {
                $usuario->password = null;

                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;

                $resultado = $usuario->guardar();
                if($resultado) {
                    header('Location: /');
                }
            }
        }
        

           



        $alertas = usuario::getAlertas();
        $router->render('/auth/recuperar',[
            'alertas'=> $alertas,
            'error'=> $error
        ]);
    }

    public static function crear(Router $router){
        $usuario = new usuario;

        //Alertas vacias
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $usuario->sincronizar($_POST);
            $alertas = $usuario ->validarcuenta();

            //Revisar que alertas este vacio
            if(empty($alertas)){
                $resultado = $usuario->existeUsuario();

                if($resultado->num_rows) {
                    $alertas = usuario::getAlertas();
                }else{
                    //Hashear el password
                    $usuario->hashPassword();

                    //Generar un token unico
                    $usuario->crearToken();

                    //Enviar el Email
                    $email = new Email($usuario->email,$usuario->nombre,$usuario->token);
                    $email->enviarConfirmacion();

                    //Crear el usuario
                    $usuario->guardar();

                   if($resultado){
                       header('Location: /mensaje');
                   }
                    

                }
            }

        }
        $router->render('/auth/crear',[
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router){
        $router->render('/auth/mensaje',[

        ]);
    }

    public static function confirmar(Router $router){
        $alertas = [];
        $token = s($_GET['token']);

        $usuario = usuario::where('token',$token);

        if(empty($usuario)){
            //Mostrar mensaje de error
            usuario::setAlerta('error','Token no valido');

        }else{
            //Modificar a usuario confirmado
            usuario::setAlerta('exito','Cuenta Confirmada con exito');
            $usuario->confirmado = "1";
            $usuario->token = null;
            $usuario->guardar();
        }
        $alertas = usuario::getAlertas();
        $router->render('auth/confirmar',[
            'alertas' => $alertas
        ]);
    }
}

?>
