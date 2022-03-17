<aside class="sidebar">
    <div class="contenedor-sidebar">
        <h2 class="write"><img src="build/img/boceto.png" alt="logo"></h2>

        <div class="cerrar-menu">
            <button id="cerrar-menus">X</button>
        </div>
    </div>

    <nav class="sidebar-nav">
        <a class="<?php echo ($titulo === 'Proyectos') ? 'activo' : '' ?>" href="/dashboard">Proyectos</a>
        <a class="<?php echo ($titulo === 'Nuevo Proyecto') ? 'activo' : '' ?>" href="/crear-proyecto">Crear Proyecto</a>
        <a class="<?php echo ($titulo === 'Perfil') ? 'activo' : '' ?>" href="/perfil">Perfil</a>
    </nav>

    <div class="cerrar-sesion-mobile">
        <a href="/logout" class="cerrar-sesion">Cerrar Sesión</a>
    </div>
    
</aside>