<div class="contenedor login">
    
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php' ?>

    <p class="tagline">Crear y Administra tus Proyectos desde CERO</p>

    <div class="contenedor-sm">
        <?php include_once __DIR__ . '/../templates/alertas.php' ?>
        <form class="formulario" action="/" method="POST" novalidate>
            <div class="campo">    
                <label for="email"></label>
                <input 
                    class="campo-son"
                    type="email"
                    id="email"
                    placeholder="Correo electrónico"
                    name="email"
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

            <input type="submit" class="boton" value="Iniciar Sesión">
        </form>

        <div class="acciones">
            <a href="/crear">Crear una cuenta .Write</a>
            <a href="/olvide">Olvide mi Contraseña</a>
        </div>
    </div> <!-- Contenedor SM -->
</div>