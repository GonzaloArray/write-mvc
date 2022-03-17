<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;

    }
    
    public function enviarConfirmacion(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '0f0b62700b56e3';
        $mail->Password = 'b400093953e1b9';

        $mail->setFrom('soporte@write.com');
        $mail->addAddress('soporte@write.com', 'write.com');
        $mail->Subject = 'Confirma tu cuenta';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        //Contenido HTML
        $contenido = '<html>';
        $contenido .= "<p><strong>Hola ". $this->nombre ."</strong> Has creado tu cuenta en .Write</p>";
        $contenido .= "<p>Presione aquí: <a href='http://localhost:3000/confirmar?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si tu no creaste esta cuenta, puedes ignorar este mensaje</p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;

        //Enviar el email
        $mail->send();
    }

    public function enviarInstrucciones(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '0f0b62700b56e3';
        $mail->Password = 'b400093953e1b9';

        $mail->setFrom('soporte@write.com');
        $mail->addAddress('soporte@write.com', 'write.com');
        $mail->Subject = 'Restablece tu Password';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        //Contenido HTML
        $contenido = '<html>';
        $contenido .= "<p><strong>Hola ". $this->nombre ."</strong> Parece que olvidaste tu Password, sigue el siguiente enlace para restablecerlo.</p>";
        $contenido .= "<p>Presione aquí: <a href='http://localhost:3000/restablecer?token=" . $this->token . "'>Restablecer Password</a></p>";
        $contenido .= "<p>Si tu no creaste esta cuenta, puedes ignorar este mensaje</p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;

        //Enviar el email
        $mail->send();
    }
}