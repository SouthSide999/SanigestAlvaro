<?php

namespace Model;

class Cliente extends ActiveRecord
{
    protected static $tabla = 'cliente';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'codigo_predio', 'dni', 'celular', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $password2;
    public $codigo_predio;
    public $dni;
    public $celular;
    public $token;


    // Campos auxiliares (opcional para cambio de contraseña)
    public $password_actual;
    public $password_nuevo;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->codigo_predio = $args['codigo_predio'] ?? '';
        $this->dni = $args['dni'] ?? '';
        $this->celular = $args['celular'] ?? '';
        $this->token = $args['token'] ?? '';

        $this->password_actual = $args['password_actual'] ?? '';
        $this->password_nuevo = $args['password_nuevo'] ?? '';
    }

    // Validar login
    public function validarLogin()
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio.';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'El email no es válido.';
        }

        if (!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatoria.';
        }

        return self::$alertas;
    }

    // Comprobar contraseña actual
    public function comprobar_password(): bool
    {
        return password_verify($this->password_actual, $this->password);
    }

    // Validar datos generales (para registro o edición)
    public function validar_cuenta()
    {
        if (!$this->codigo_predio) {
            self::$alertas['error'][] = 'El Código de Predio es obligatorio';
        }

        if (!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es obligatorio';
        }

        if (!$this->apellido) {
            self::$alertas['error'][] = 'El Apellido es obligatorio';
        }

        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es obligatorio';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'El Email no es válido';
        }

        if (!$this->password) {
            self::$alertas['error'][] = 'El Password no puede ir vacío';
        } elseif (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El Password debe contener al menos 6 caracteres';
        }

        if ($this->password !== $this->password2) {
            self::$alertas['error'][] = 'Los Passwords son diferentes';
        }

        if (!$this->dni) {
            self::$alertas['error'][] = 'El DNI es obligatorio';
        } elseif (!preg_match('/^\d{8}$/', $this->dni)) {
            self::$alertas['error'][] = 'El DNI debe tener 8 dígitos';
        }

        if (!$this->celular) {
            self::$alertas['error'][] = 'El número de celular es obligatorio';
        } elseif (!preg_match('/^\d{9}$/', $this->celular)) {
            self::$alertas['error'][] = 'El número de celular debe tener 9 dígitos';
        }

        return self::$alertas;
    }

    // Hashea el password
    public function hashPassword(): void
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }
    public function validar_cliente()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre no puede ir vacío';
        }
        if (!$this->apellido) {
            self::$alertas['error'][] = 'El Apellido no puede ir vacío';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email no puede ir vacío';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'El Email no es válido';
        }
        if (!$this->dni) {
            self::$alertas['error'][] = 'El DNI no puede ir vacío';
        } elseif (!preg_match('/^\d{8}$/', $this->dni)) {
            self::$alertas['error'][] = 'El DNI debe tener 8 dígitos numéricos';
        }
        if (!$this->celular) {
            self::$alertas['error'][] = 'El celular no puede ir vacío';
        } elseif (!preg_match('/^\d{9}$/', $this->celular)) {
            self::$alertas['error'][] = 'El celular debe tener 9 dígitos numéricos';
        }
        if (!$this->codigo_predio) {
            self::$alertas['error'][] = 'Debe seleccionar un predio';
        }
        return self::$alertas;
    }

    // Generar un Token
    public function crearToken(): void
    {
        $this->token = uniqid();
    }

    // Valida un email
    public function validarEmail()
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no válido';
        }
        return self::$alertas;
    }

    // Valida el Password 
    public function validarPassword()
    {
        if (!$this->password) {
            self::$alertas['error'][] = 'El Password no puede ir vacio';
        }
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
        }
        return self::$alertas;
    }
}
