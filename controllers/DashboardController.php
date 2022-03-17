<?php

namespace Controllers;

use Model\Proyecto;
use Model\Usuario;
use MVC\Router;

class DashboardController{
    public static function index(Router $router){
        session_start();
        isAuth();
        //Aca buscamos el id y lo buscamos todos los objetos
        $id = $_SESSION['id'];
        $proyectos = Proyecto::belongsTo('propietario_id', $id);

        $router->render('dashboard/index', [
            'titulo' => 'Proyectos',
            'proyectos' => $proyectos
        ]);
    }

    public static function crear_proyecto(Router $router){
        session_start();
        isAuth();
        //Llamo a la alerta en un arreglo vacio
        $alertas = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proyecto = new Proyecto($_POST);

            $alertas = $proyecto->validarProyecto(); 
            //Vamos a validar, si alerta esta vacio, podemos agregar la funcion guardar
            if (empty($alertas)) {
                //Generar un URL Unica
                $hash = md5(uniqid());
                $proyecto->url = $hash;
                //Almacenar el creador de proyecto
                $proyecto->propietario_id = $_SESSION['id'];
                //Guardar el Proyecto
                $proyecto->guardar();
                //Ahora una vez completado el hasheo y que no alla fallo de alerta, vamos a redireccionar a su propia url
                header('Location: /proyecto?id=' . $proyecto->url);
            }
        }

        $router->render('dashboard/crear-proyecto', [
            'alertas' => $alertas,
            'titulo' => 'Nuevo Proyecto'
        ]);
    }

    public static function proyecto(Router $router){
        session_start();
        isAuth();

        //leemos a buscar la url
        $url = $_GET['id'];
        if (!$url) header('Location: /dashboard');
        //Revisar que la persona que visita el proyecto, es quien creo el proyecto
        //Buscamos la url
        $proyecto = Proyecto::where('url', $url);
        //Si no es la misma url que estamos llamando. lo redireccionamos
        if ($proyecto->propietario_id !== $_SESSION['id']) {
            header('Location: /dashboard');
        }

        $router->render('dashboard/proyecto', [
            'titulo' => $proyecto->proyecto
        ]);
    }

    public static function perfil(Router $router){
        session_start();
        //Vamos a proteger la url para que nadie pueda entrar, que no sea el usuario auntenticado
        isAuth();
        //Le pasamos las alertas
        $alertas = [];
        //Vamos a buscar el id, este id siempre va arriba del request method, para que lo pueda leer
        $usuario = Usuario::find($_SESSION['id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //VAmos a sincronizar al usuario con la funcon creada, le vamos a mandar metodo post
            $usuario->sincronizar($_POST);

            //Mandamos las alertas en caso de que este vacio el nombre e email
            $alertas = $usuario->validar_perfil();

            if (empty($alertas)) {
                //Antes de realizar la validacion vamos a verificar que el usuario no este validando con un usuario que ya este verificado y lo reeescriba
                $existeUsuario = Usuario::where('email', $usuario->email);

                //Si existe usuario tenemos que verificar que exista y no este usando el nombre de otro usuario
                if ($existeUsuario && $existeUsuario->id !== $usuario->id) {
                    //Si existe, vamos a mandarle un mensaje de error
                    Usuario::setAlerta('error', 'Este email ya existe!');
                    $alertas = $usuario->getAlertas();
                } else {
                    //Si no existe, vamos a guardar el registro

                    //Guardar el usuario
                    $usuario->guardar();

                    //Le vamos a poner alerta al modelo de usuario
                    Usuario::setAlerta('exito', 'Guardado correctamente');
                    $alertas = $usuario->getAlertas();

                    //Ahora vamos a reescribir los nombre para que se muestren en la base de datos
                    //Como ya tenemos la instancia arriba, ya poder cambiar el nombre
                    //Entonces ya lo actulizamos con el ultimo valor disponible
                    $_SESSION['nombre'] = $usuario->nombre;                 
                }

                
            }
        }

        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function cambiar_password(Router $router){
        session_start();
        isAuth();
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = Usuario::find($_SESSION['id']);

            //Ahora teneemos que sincronizar con los datos del usuario
            $usuario->sincronizar($_POST);
            $alertas = $usuario->nuevo_password();

            //Validacion en caso que este vacio
            if (empty($alertas)) {
                //Vamos a crearun metodo para comprobar password
                $resultado = $usuario->comprobarPassword();
                
                if ($resultado) {
                    //Si este password es correcto vamos a retornar un true
                    //Una vez que sea correcto
                    //asignar un nuevo password
                    $usuario->password = $usuario->password_nuevo;

                    //Eliminar propiedades no necesarias
                    unset($usuario->password_actual);
                    unset($usuario->password_nuevo);

                    //Hashear el nuevo password
                    $usuario->hashPassword();

                    //actualizar
                    $resultado = $usuario->guardar();

                    if ($resultado) {
                        Usuario::setAlerta('exito', 'Contraseña guardada correctamente');
                        $alertas = $usuario->getAlertas();    
                    }
                } else {
                    Usuario::setAlerta('error', 'Contraseña incorrecta');
                    $alertas = $usuario->getAlertas();
                }
            }
        }

        $router->render('dashboard/cambiar_password', [
            'titulo' => 'Cambiar Contraseña',
            'alertas' => $alertas
        ]);
    }
}