<?php

namespace Model;

class Usuario extends ActiveRecord{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->password_actual = $args['password_actual'] ?? '';
        $this->password_nuevo = $args['password_nuevo'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }
    //Validar el Login del usuario
    public function validarLogin(){
        if (!$this->email) {
            self::$alertas['error'][] = 'Correo electronico Obligatorio';
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no valido';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'Contraseña Obligatorio';
        }
    }

    //Validacion para cuentas nuevas
    public function validarNuevaCuenta(){
        if (!$this->nombre) {
            self::$alertas['error'][] = 'Nombre Obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'Correo electronico Obligatorio';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'Contraseña Obligatorio';
        }
        //Creamos un poco más de seguridad para Password
        //Si password no cumple con la cantidad de caracter, return mensaje de obligación
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'Min 6 Caracteres';
        }
        //Doble validacion de password, p1 y p2
        if ($this->password !== $this->password2) {
            self::$alertas['error'][] = 'Las contraseñas son diferentes';
        }

        return self::$alertas;
    }
    //Valida un email
    public function validarEmail(){
        if (!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no valido';
        }

        return self::$alertas;
    }

    //Valida el Password
    public function validarPassword(){
        if (!$this->password) {
            self::$alertas['error'][] = 'Contraseña Obligatorio';
        }
        //Creamos un poco más de seguridad para Password
        //Si password no cumple con la cantidad de caracter, return mensaje de obligación
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'Min 6 Caracteres';
        }
        //Doble validacion de password, p1 y p2
        if ($this->password !== $this->password2) {
            self::$alertas['error'][] = 'Las contraseñas son diferentes';
        }

        return self::$alertas;
    }
    public function validar_perfil(){
        if (!$this->nombre) {
            self::$alertas['error'][] = 'Nombre Obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'Correo electronico Obligatorio';
        }
        return self::$alertas;
    }

    public function nuevo_password() : array {
        if (!$this->password_actual) {
            self::$alertas['error'][] = 'La contraseña actual no puede ir vacia';
        }
        if (!$this->password_nuevo) {
            self::$alertas['error'][] = 'La contraseña nueva no puede ir vacia';
        }
        //strlen nos permite verificar la extension de un string
        if (strlen($this->password_nuevo) < 6) {
            self::$alertas['error'][] = 'min 6 caracteres';
        }
        return self::$alertas;
    }

    //Comprobar password
    public function comprobarPassword() : bool {
        return password_verify($this->password_actual, $this->password);
    }

    //Hashea el password
    public function hashPassword() : void{
        //Vamos a usar la funcion de PHP para hashear
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);

    }

    //Genear un TOKEN para validacion
    public function crearToken() : void{
        //Esta funcion uniq propia de PHP no la utilices para hashear, es muy insegura
        $this->token = uniqid();
    }
}