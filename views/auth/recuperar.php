<h1 class="nombre-pagina">Recuperar Password</h1>
<p class="descripcion-pagina">"Ingresa tu nuevo Password a continuacion."</p>
<?php include_once __DIR__ . '/../templates/alertas.php'  ?>

<?php if($error) return; ?>
<form  class="formulario" method="POST">
    <div class="campo">
        <label for="password">Password: </label>
        <input 
        type="password"
        id="password"
        name="password"
        placeholder="Tu nuevo Passoword"
        /> 
    </div>
    <input type="submit" class="boton" value="Guardar Nuevo Password"/>
</form>

<div class="acciones">
    <a href="/crearcuenta">Aun no tienes una cuenta? Crear Una</a>
    <a href="/">Ya tienes cuenta? Iniciar Sesion</a>
</div>