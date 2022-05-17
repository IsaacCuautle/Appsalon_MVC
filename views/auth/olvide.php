<h1 class="nombre-pagina">Olvide Password</h1>
<p class="descripcion-pagina">Reestablece tu password escribiendo tu email acontinuacion</p>
<?php include __DIR__ . '/../templates/alertas.php' ?>

<form class="formulario" accion="/olvide" method="POST" >
<div class="campo">
    <label for="email">E-mail</label>
    <input
    type="email"
    id="email"
    name="email"
    placeholder="Tu E-mail"
    />
</div>
<input type="submit" class="boton" value="Enviar Instrucciones">

<div class="acciones">
    <a href="/">Ya tienes una cuenta? Inicia Sesion</a>
    <a href="/crearcuenta">Aun no tienes una cuenta? Crea Una</a>
</div>
</form>