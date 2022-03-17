<div class="contenedor login">
    
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php' ?>
    <div class="separacion">
        <p class="tagline">Restablecer contraseña</p>
        
        <div class="contenedor-sm">

            <?php include_once __DIR__ . '/../templates/alertas.php' ?>

            <?php if ($mostrar) {   ?>

            <form class="formulario" method="POST">
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

                <input type="submit" class="boton" value="Guardar Contraseña">
            </form>

            <!-- Si mostrar es igual a true, va mostrar este contenido -->
            <?php } ?>

            <div class="acciones">
                <a href="/">Iniciar Sesión</a>
            </div>
        </div>
    </div> <!-- Contenedor SM -->
    
</div>