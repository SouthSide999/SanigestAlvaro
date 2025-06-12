<?php

function debuguear($variable): string
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
function s($html): string
{
    $s = htmlspecialchars($html);
    return $s;
}

function sanitizarBusqueda($valor): ?string {
    if (!isset($valor)) return null;
    return htmlspecialchars(trim($valor), ENT_QUOTES, 'UTF-8');
}

function pagina_actual($path): bool
{
    return str_contains($_SERVER['PATH_INFO'] ?? '/', $path) ? true : false;
}

function is_auth(): bool
{
    if (!isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION['nombre']) && !empty($_SESSION);
}
function is_admin(): bool
{
    if (!isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION['rol_id']) && (int)$_SESSION['rol_id'] === 2;
}
function is_usuario(): bool
{
    if (!isset($_SESSION)) {
        session_start();
    }

    return isset($_SESSION['usuario']) && $_SESSION['usuario'] === true;
}
function is_tesorero(): bool
{
    if (!isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION['rol_id']) && (int)$_SESSION['rol_id'] === 3;
}
function is_tecnico(): bool
{
    if (!isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION['rol_id']) && (int)$_SESSION['rol_id'] === 4;
}
function is_lecturador(): bool
{
    if (!isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION['rol_id']) && (int)$_SESSION['rol_id'] === 5;
}

function aos_animacion(): void
{ //para añadir efectos
    $efectos = ['fade-up', 'fade-down', 'fade-left', 'fade-right', 'flip-left', 'flip-right', 'zoom-in', 'zoom-in-up', 'zoom-in-down', 'zoom-out'];
    $efecto = array_rand($efectos, 1);
    echo ' data-aos="' . $efectos[$efecto] . '" ';
}

function nombreMes($numeroMes)
{
    $meses = [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre'
    ];
    return $meses[intval($numeroMes)] ?? 'Desconocido';
}
