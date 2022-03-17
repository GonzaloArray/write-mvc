<div class="contenedor login">

    <?php include_once __DIR__ . '/../templates/nombre-sitio.php' ?>
    <p class="tagline">Recupera tu acceso</p>
    
    <div class="separacion">
        <?php include_once __DIR__ . '/../templates/alertas.php' ?>
        <div class="contenedor-sm">
            <form class="formulario" action="/olvide" method="POST" novalidate>
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

                <input type="submit" class="boton" value="Iniciar Sesión">
            </form>

            <div class="acciones">
                <a href="/">Iniciar Sesión</a>
                <a href="/crear">Crear una cuenta .Write</a>
            </div>
        </div>
    </div> <!-- Contenedor SM -->
    
</div>