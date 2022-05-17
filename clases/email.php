<?php 

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $nombre;
    public $token;

    public function __construct($email,$nombre,$token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
        
    }

    public function enviarConfirmacion() {
        //crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();                                           
        $mail->Host = 'smtp.mailtrap.io';                    
        $mail->SMTPAuth = true;
        $mail->Port = 2525;                                   
        $mail->Username = '00b7e2e9cf6fe4';                     
        $mail->Password = '747d6435f5075a';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com','Appsalon.com');
        $mail->Subject='Confirma tu cuenta';

        //Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet= 'utf-8';

        $contenido ="<html>";
        $contenido .= "<p><strong>Hola ".$this->nombre." </strong> Has creado tu cuenta en AppSalon, confirma tu cuenta dando click en el siguiente enlace</p>";
        $contenido .= "<p>Presiona aqui: <a href='http://localhost:3000/confirmarcuenta?token=".$this->token."'>Confirmar cuenta</a></p>";
        $contenido .= "<p>Si no has solicitado este servicio Ignora este mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //Enviar el email
        $mail->send();
        
    }

    public function enviarInstrucciones(){
         //crear el objeto de email
         $mail = new PHPMailer();
         $mail->isSMTP();                                           
         $mail->Host = 'smtp.mailtrap.io';                    
         $mail->SMTPAuth = true;
         $mail->Port = 2525;                                   
         $mail->Username = '00b7e2e9cf6fe4';                     
         $mail->Password = '747d6435f5075a';
 
         $mail->setFrom('cuentas@appsalon.com');
         $mail->addAddress('cuentas@appsalon.com','Appsalon.com');
         $mail->Subject='Reestablecimiento de Password';
 
         //Set HTML
         $mail->isHTML(TRUE);
         $mail->CharSet= 'utf-8';
 
         $contenido ="<html>";
         $contenido .= "<p><strong>Hola ".$this->nombre." </strong>Has Solicitado el reestablecimiento de tu Password</p>";
         $contenido .= "<p>Presiona aqui: <a href='http://localhost:3000/recuperar?token=".$this->token."'>Reestablecer Password</a></p>";
         $contenido .= "<p>Si no has solicitado este servicio Ignora este mensaje</p>";
         $contenido .= "</html>";
 
         $mail->Body = $contenido;
 
         //Enviar el email
         $mail->send();
    }
}

?>