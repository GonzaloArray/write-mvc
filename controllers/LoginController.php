<?php


namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    public static function login(Router $router){
        //Creamos siempre que se necesario el arreglo de alertas
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Lo primero que vamos hacer aca es crear una variable auth de auntenticacion
            $usuario = new Usuario($_POST);

            $alertas = $usuario->validarLogin();

            //En que no pase la validacion
            if (empty($alertas)) {
                //Verificar que el usuario exista
                $usuario = Usuario::where('email', $usuario->email);

                if (!$usuario || !$usuario->confirmado) {
                    Usuario::setAlerta('error', 'El usuario no existe');
                } else {
                    //Comprobar si el usuario existe
                    if (password_verify($_POST['password'], $usuario->password)) {

                        //Iniciar la sesion
                        //Le pasamos el id, el nombre, un boleano para saber que es ese login, el correo donde se esta logeando
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;
                        
                        //Redireccionar 
                        header('Location: /dashboard');

                    } else {
                        Usuario::setAlerta('error', 'Contraseña Incorrecta');

                    }
                }
            }
        }
        //Mandamos las alertas
        $alertas = Usuario::getAlertas();
        //Render a la vista
        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesion',
            'alertas' => $alertas
        ]);
    }

    public static function logout(){
        session_start();
        $_SESSION = [];
        header('Location: /');

    }

    public static function crear(Router $router){
        $alertas = [];
        $usuario = new Usuario;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);

            $alertas = $usuario->validarNuevaCuenta();

            //Vamos a dar un mensaje a crear si alerta esta vacio
            if (empty($alertas)) {
                $existeUsuario = Usuario::where('email', $usuario->email);

                if ($existeUsuario) {
                    Usuario::setAlerta('error', 'El usuario ya existe');
                    $alertas = Usuario::getAlertas();
                }else {
                    //Hashear el Password
                    $usuario->hashPassword();

                    //Eliminar Password2
                    unset($usuario->password2);

                    //Generar Token
                    $usuario->crearToken();

                    //En caso contrario, Crear un Nuevo Usuario
                    $resultado = $usuario->guardar();

                    //Enviar Email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();
                    
                    if ($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }

        //Render a la vista
        $router->render('auth/crear', [
            'titulo' => 'Crear Usuario',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function olvide(Router $router){
        $alertas = [];

        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Vamos a validar al usuario
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();

            if (empty($alertas)) {
                //Buscar el usuario
                $usuario = Usuario::where('email', $usuario->email);

                
                if ($usuario && $usuario->confirmado) {
                    //Una vez encontrado al usuario vamos a:
                    //Generar un nuevo Token
                    $usuario->crearToken();
                    //Sacamos de este array la parte
                    unset($usuario->password2);

                    //Actualizar el usuario
                    $usuario->guardar();

                    //Enviar el email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarInstrucciones();

                    //Imprimir la alerta
                    Usuario::setAlerta('exito', 'Revisa tu email');

                } else {
                    //Que no encontre al usuario con un alerta
                    Usuario::setAlerta('error', 'El usuario no existe');
                }
            }
            
        }
        //Poco antes que se muestre la vista, le mandamos los mensajes de error o exito
        $alertas = Usuario::getAlertas();

        //Render a la vista
        $router->render('auth/olvide', [
            'titulo' => 'Olvide Contraseña',
            'alertas' => $alertas
        ]);
    }

    public static function restablecer(Router $router){
        
        $token = s($_GET['token']);
        //Creamos una variable
        $mostrar = true;

        if(!$token) header('Location: /');

        //Identificar el usuario con este token
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            Usuario::setAlerta('error', 'Token no valido');
            //Si es un token no valido, voy a pasar la variable mostrar a false
            $mostrar = false;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Añadir el nuevo Password
            //Vamos asincronizarlo con POST
            $usuario->sincronizar($_POST);

            //Vamos a validar el email
            $usuario->validarPassword();

            //Si tenemos vacia la validacion, quiere decir que nos tomo el nuevo password
            if (empty($alertas)) {
                //Hashear el nuevo password
                $usuario->hashPassword();

                //Eliminar Password2
                unset($usuario->password2);

                //Eliminar el token
                $usuario->token = '';

                //Guardar el usuario en la BD
                $resultado = $usuario->guardar();

                //Redireccionar
                if ($resultado) {
                    header('Location: /');
                }
            }
        }
        //Antes de mostrarle al usuario subimos las alertas
        $alertas = Usuario::getAlertas();

        //Render a la vista
        $router->render('auth/restablecer', [
            'titulo' => 'Restablecer Contraseña',
            'alertas' => $alertas,
            'mostrar' => $mostrar

        ]);
    }
    
    
    public static function mensaje(Router $router){

        //Render a la vista
        $router->render('auth/mensaje', [
            'titulo' => 'Registro Exitoso'
        ]);
    }

    public static function confirmar(Router $router){
        $token = s($_GET['token']);

        if (!$token) header('Location: /');

        //Encontrar usuario con este token
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            //No se encontro un usuario con ese token
            Usuario::setAlerta('error', 'Token no valido');
        } else {
            //Confirmar cuenta
            $usuario->confirmado = 1;
            $usuario->token = "";
            unset($usuario->password2);

            //Una vez verificado vamos a guardarlo
            $usuario->guardar();

            Usuario::setAlerta('exito', 'Cuenta confirmada correctamente');
        }

        $alertas = Usuario::getAlertas();

        //Render a la vista
        $router->render('auth/confirmar', [
            'titulo' => 'Confirmación',
            'alertas' => $alertas 
        ]);
    }
    
}