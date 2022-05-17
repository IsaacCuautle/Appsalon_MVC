<h1 class="nombre-pagina">Crear Nueva cita</h1>
<p class="descripcion-pagina">Elige tus servicios y coloca tus datos</p>
<?php include_once __DIR__  . '/../templates/barra.php' ?>
<div id="app">
    <nav class="tabs">
        <button type="button" data-paso="1" class="actual">Servicios</button>
        <button type="button" data-paso="2">Tus datos y cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>
    <div id="paso-1" class="seccion">
    <h2>Servicios</h2>
    <p class="text-center">Elije tus servicios acontinuacion</p>
    <div id="servicios" class="listado-servicios"></div>
    </div>

    <div id="paso-2" class="seccion">
    <h2>Tus datos y cita</h2>
    <p class="text-center">Coloca tus datos y fecha de tu cita</p>

    <form class="formulario">
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input 
            id="nombre"
            type="text"
            placeholder="Tu nombre"
            value="<?php echo $nombre ?>"
            disabled
            />
        </div>

        <div class="campo">
            <label for="fecha">Fecha</label>
            <input 
            id="fecha"
            type="date"
            min="<?php echo date('Y-m-d', strtotime('+1day')) ?>"
            />
        </div>

        

        <div class="campo">
            <label for="hora">Hora</label>
            <input 
            id="hora"
            type="time"
            />
        </div>
        <input type="hidden" id="id" value="<?php echo $id; ?>">
    </form>
    </div>

    <div id="paso-3" class="seccion contenido-resumen">
    <h2>Resumen</h2>
    <p class="text-center">Verifica que la informacion sea correcta</p>
    </div>

    <div class="paginacion">
        <button id="anterior" class="boton">&laquo; Anterioir</button>
        <button id="siguiente" class="boton">Siguiente &raquo;</button>
    </div>
</div>

<?php 
$script = "<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script src='build/js/app.js'></script>";
?>