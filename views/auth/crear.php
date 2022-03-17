<div class="contenedor login">
    
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php' ?>
    <div class="crear-cuenta">
        <p class="tagline">Crear Cuenta</p>
        
        <div class="contenedor-sm">

            <?php include_once __DIR__ . '/../templates/alertas.php' ?>

            <form class="formulario" action="/crear" method="POST">
            <div class="campo">    
                <label for="nombre"></label>
                <input 
                    class="campo-son"
                    type="text"
                    id="nombre"
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
                    id="email"
                    placeholder="Correo electrónico"
                    name="email"
                    value="<?php echo $usuario->email; ?>"
                >
            </div>

            <div class="campo">
                <label for="password"></label>
                <input 
                    class="campo-son"
                    type="password"
                    id="password"
                    placeholder="Contraseña"
                    name="password"
                >
            </div>
            <div class="campo">
                <label for="password2"></label>
                <input 
                    class="campo-son"
                    type="password"
                    id="password2"
                    placeholder="Repetir contraseña"
                    name="password2"
                >
            </div>
                <input type="submit" class="boton" value="Crear Cuenta">
            </form>

            <div class="acciones">
                <a href="/">Iniciar Sesión</a>
                <a href="/olvide
                ">Olvide mi Contraseña</a>
            </div>
        </div>
    </div> <!-- Contenedor SM -->
    
</div>