<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Notificaciones
{
    public $email;
    public $nombre;
    public $apellido;
    public $direccion;
    public $observacion;


    public function __construct($email, $nombre, $apellido)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
    }

    public function enviarAsignacionNuevaConexion($direccion = null)
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('sanigesthuaro@gmail.com');
        $mail->addAddress($this->email, $this->nombre . ' ' . $this->apellido);
        $mail->Subject = 'Nueva Asignación de Trabajo - SaniGest';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong>Hola " . $this->nombre . " " . $this->apellido . ",</strong></p>";
        $contenido .= "<p>Te informamos que desde <strong>SaniGest</strong> se te ha asignado un nuevo trabajo relacionado con una <strong>NUEVA CONEXIÓN DE AGUA Y SANEAMIENTO</strong>.</p>";
        $contenido .= "<p><strong>Dirección del trabajo:</strong> " . $direccion . "</p>";
        $contenido .= "<p>Por favor, ingresa a tu panel técnico en el sistema de SaniGest para más detalles y seguimiento del trabajo.</p>";
        $contenido .= "<br>";
        $contenido .= "<p><em>Este mensaje ha sido enviado automáticamente por el sistema de gestión de agua y saneamiento - SaniGest.</em></p>";
        $contenido .= "<p>Gracias por tu compromiso y dedicación.<br><strong>Equipo SaniGest</strong></p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;

        $mail->send();
    }

    public function enviarConexionFinalizadaCliente($direccion = null)
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('sanigesthuaro@gmail.com');
        $mail->addAddress($this->email, $this->nombre . ' ' . $this->apellido);
        $mail->Subject = 'Conexión Finalizada - SaniGest';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong>Hola " . $this->nombre . " " . $this->apellido . ",</strong></p>";
        $contenido .= "<p>Nos complace informarte que el trabajo correspondiente a tu <strong>NUEVA CONEXIÓN DE AGUA Y SANEAMIENTO</strong> ha sido <strong>finalizado exitosamente</strong>.</p>";

        if (!empty($direccion)) {
            $contenido .= "<p><strong>Dirección:</strong> " . $direccion . "</p>";
        }

        $contenido .= "<p>Gracias por confiar en el sistema de gestión SaniGest. Si tienes alguna consulta adicional, no dudes en contactarnos.</p>";
        $contenido .= "<br>";
        $contenido .= "<p><em>Este mensaje ha sido generado automáticamente por el sistema de agua y saneamiento - SaniGest.</em></p>";
        $contenido .= "<p>Saludos cordiales,<br><strong>Equipo SaniGest</strong></p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;

        $mail->send();
    }

    public function enviarObservacionRechazoCliente($direccion = null, $observacion = null)
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('sanigesthuaro@gmail.com');
        $mail->addAddress($this->email, $this->nombre . ' ' . $this->apellido);
        $mail->Subject = 'Observación en Conexión - SaniGest';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong>Hola " . htmlspecialchars($this->nombre) . " " . htmlspecialchars($this->apellido) . ",</strong></p>";
        $contenido .= "<p>Queremos informarte que el trabajo para tu <strong>nueva conexión de agua</strong> ha sido <strong>observado o rechazado</strong> por el siguiente motivo:</p>";

        if (!empty($observacion)) {
            $contenido .= "<p><strong>Motivo:</strong> " . htmlspecialchars($observacion) . "</p>";
        }

        if (!empty($direccion)) {
            $contenido .= "<p><strong>Dirección:</strong> " . htmlspecialchars($direccion) . "</p>";
        }

        $contenido .= "<p>Te invitamos a acercarte a la UGM de la Municipalidad Distrital de Huaro para más información.</p>";
        $contenido .= "<br>";
        $contenido .= "<p><em>Este mensaje ha sido generado automáticamente por el sistema de agua y saneamiento - SaniGest.</em></p>";
        $contenido .= "<p>Atentamente,<br><strong>Equipo SaniGest</strong></p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;

        $mail->send();
    }

    public function enviarBienvenidaCliente()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('sanigesthuaro@gmail.com');
        $mail->addAddress($this->email, $this->nombre . ' ' . $this->apellido);
        $mail->Subject = '¡Bienvenido a SaniGest! - Cuenta Creada con Éxito';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong>Hola " . $this->nombre . " " . $this->apellido . ",</strong></p>";
        $contenido .= "<p>¡Bienvenido a <strong>SaniGest</strong>! Tu cuenta ha sido <strong>creada exitosamente</strong>.</p>";
        $contenido .= "<p>Ahora podrás acceder a nuestro sistema para gestionar tu conexión de agua y saneamiento, revisar tu información, reportar reclamos, ver facturación y más.</p>";

        $contenido .= "<p>Te recomendamos iniciar sesión con tu correo electrónico registrado y la contraseña que creaste durante el registro.</p>";
        $contenido .= "<br>";
        $contenido .= "<p><em>Este mensaje fue generado automáticamente por el sistema de agua y saneamiento - SaniGest.</em></p>";
        $contenido .= "<p>Gracias por confiar en nosotros.<br><strong>Equipo SaniGest</strong></p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;

        $mail->send();
    }
    public function enviarActualizacionCuentaCliente($nuevaPassword = null)
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('sanigesthuaro@gmail.com');
        $mail->addAddress($this->email, $this->nombre . ' ' . $this->apellido);
        $mail->Subject = 'Actualización de Datos - SaniGest';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong>Hola " . $this->nombre . " " . $this->apellido . ",</strong></p>";
        $contenido .= "<p>Te informamos que los datos de tu cuenta en <strong>SaniGest</strong> han sido <strong>actualizados correctamente</strong>.</p>";

        if ($nuevaPassword) {
            $contenido .= "<p><strong>Nueva contraseña:</strong> " . $nuevaPassword . "</p>";
        } else {
            $contenido .= "<p>No realizaste cambios en tu contraseña.</p>";
        }

        $contenido .= "<p>Si no reconoces esta modificación, comunícate de inmediato con el equipo de soporte.</p>";
        $contenido .= "<br>";
        $contenido .= "<p><em>Este mensaje fue generado automáticamente por el sistema de agua y saneamiento - SaniGest.</em></p>";
        $contenido .= "<p>Gracias por confiar en nosotros.<br><strong>Equipo SaniGest</strong></p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;

        $mail->send();
    }
    public function enviarNotificacionSolicitud($codigoSeguimiento = null)
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('sanigesthuaro@gmail.com');
        $mail->addAddress($this->email, $this->nombre . ' ' . $this->apellido);
        $mail->Subject = 'Confirmación de Solicitud - SaniGest';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong>Hola {$this->nombre} {$this->apellido},</strong></p>";
        $contenido .= "<p>Hemos recibido tu <strong>solicitud</strong> correctamente.</p>";
        $contenido .= "<p>Tu <strong>código de seguimiento</strong> es: <strong>{$codigoSeguimiento}</strong></p>";
        $contenido .= "<p>Podrás consultar el estado en cualquier momento en la plataforma SaniGest.</p>";
        $contenido .= "<br><p>Gracias por confiar en nosotros.<br><strong>Equipo SaniGest</strong></p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;
        $mail->send();
    }
    public function enviarNotificacionNuevaConexion($codigoSeguimiento = null)
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('sanigesthuaro@gmail.com');
        $mail->addAddress($this->email, $this->nombre . ' ' . $this->apellido);
        $mail->Subject = 'Confirmación de Nueva Conexión - SaniGest';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong>Hola {$this->nombre} {$this->apellido} ,</strong></p>";
        $contenido .= "<p>Hemos recibido correctamente tu <strong>solicitud de nueva conexión</strong>.</p>";
        $contenido .= "<p>Tu <strong>código de seguimiento</strong> es: <strong>{$codigoSeguimiento}</strong></p>";
        $contenido .= "<p>Podrás verificar el estado de tu solicitud en cualquier momento desde la plataforma SaniGest.</p>";
        $contenido .= "<br><p>Gracias por confiar en nosotros.<br><strong>Equipo SaniGest</strong></p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;
        $mail->send();
    }
    public function enviarAsignacionSolicitud($tipoSolicitud = null, $descripcion = null)
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('sanigesthuaro@gmail.com');
        $mail->addAddress($this->email, $this->nombre . ' ' . $this->apellido);
        $mail->Subject = 'Nueva Solicitud Asignada - SaniGest';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong>Hola " . $this->nombre . " " . $this->apellido . ",</strong></p>";
        $contenido .= "<p>Desde <strong>SaniGest</strong> se te ha asignado una nueva <strong>SOLICITUD</strong> para atención.</p>";

        if ($tipoSolicitud) {
            $contenido .= "<p><strong>Tipo de Solicitud:</strong> " . htmlspecialchars($tipoSolicitud) . "</p>";
        }

        if ($descripcion) {
            $contenido .= "<p><strong>Descripción:</strong><br>" . nl2br(htmlspecialchars($descripcion)) . "</p>";
        }

        $contenido .= "<p>Por favor, ingresa a tu panel técnico en el sistema de SaniGest para revisar los detalles y realizar el seguimiento correspondiente.</p>";
        $contenido .= "<br>";
        $contenido .= "<p><em>Este mensaje fue generado automáticamente por el sistema de gestión de agua y saneamiento - SaniGest.</em></p>";
        $contenido .= "<p>Gracias por tu compromiso y dedicación.<br><strong>Equipo SaniGest</strong></p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;

        $mail->send();
    }
    public function enviarSolicitudFinalizadaCliente($tipo_solicitud = null, $descripcion = null, $resolucion = null)
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('sanigesthuaro@gmail.com');
        $mail->addAddress($this->email, $this->nombre . ' ' . $this->apellido);
        $mail->Subject = 'Solicitud Resuelta - SaniGest';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong>Hola {$this->nombre} {$this->apellido},</strong></p>";
        $contenido .= "<p>Nos complace informarte que tu solicitud de tipo <strong>{$tipo_solicitud}</strong> ha sido <strong>resuelta exitosamente</strong>.</p>";
        $contenido .= "<p><strong>Descripción:</strong> {$descripcion}</p>";

        // Agregar resolución si está disponible
        if (!empty($resolucion)) {
            $contenido .= "<p><strong>Resolución:</strong> {$resolucion}</p>";
        }

        $contenido .= "<p>Gracias por confiar en el sistema de gestión de agua y saneamiento <strong>SaniGest</strong>. Si necesitas más información, no dudes en contactarnos.</p>";
        $contenido .= "<br>";
        $contenido .= "<p><em>Este mensaje ha sido generado automáticamente por el sistema SaniGest.</em></p>";
        $contenido .= "<p>Saludos cordiales,<br><strong>Equipo SaniGest</strong></p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;
        $mail->send();
    }
    public function enviarSolicitudRechazadaCliente($tipo_solicitud = null, $descripcion, $observacion = null)
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('sanigesthuaro@gmail.com');
        $mail->addAddress($this->email, $this->nombre . ' ' . $this->apellido);
        $mail->Subject = 'Solicitud Observada - SaniGest';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong>Hola {$this->nombre} {$this->apellido},</strong></p>";
        $contenido .= "<p>Tu solicitud de tipo <strong>{$tipo_solicitud}</strong> ha sido <strong>observada o rechazada</strong>.</p>";
        $contenido .= "<p><strong>Descripción:</strong> {$descripcion}</p>";
        $contenido .= "<p><strong>Observaciones:</strong> {$observacion}</p>";
        $contenido .= "<p>Por favor, realiza las correcciones necesarias o contáctanos para más información.</p>";
        $contenido .= "<br><p><em>Este mensaje fue generado automáticamente.</em></p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;
        $mail->send();
    }
}
