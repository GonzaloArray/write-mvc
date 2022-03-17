<?php include_once __DIR__ . '/header.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <a href="/cambiar_password" class="enlace">Cambiar Contraseña</a>

    <form class="formulario" method="POST" action="/perfil">
        <div class="campo">    
            <label for="nombre"></label>
            <input 
                class="campo-son"
                type="text"
                placeholder="Nombre"
                name="nombre"
                value="<?php echo $usuario->nombre; ?>"
            >
        </div>
        <div class="campo">    
            <label for="email"></label>
            <input 
                class="campo-son"
                type="email"
                placeholder="Correo electrónico"
                name="email"
                value="<?php echo $usuario->email; ?>"
            >
        </div>
        <input type="submit" value="Guardar Cambios">
    </form>
</div>

<?php include_once __DIR__ . '/footer.php'; ?>