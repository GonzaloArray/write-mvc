<?php include_once __DIR__ . '/header.php'; ?>

<div class="contenedor-sm">
    <a href="/perfil" class="enlace">Volver a perfil</a>

    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
    <form class="formulario" method="POST" action="/cambiar_password">
        <div class="campo">    
            <label for="nombre"></label>
            <input 
                type="password"
                name="password_actual"
                placeholder="Contraseña actual"
            >
        </div>
        <div class="campo">    
            <label for="nombre"></label>
            <input 
                type="password"
                name="password_nuevo"
                placeholder="Nueva contraseña"
            >
        </div>
        <input type="submit" value="Guardar Cambios">
    </form>
</div>

<?php include_once __DIR__ . '/footer.php'; ?>