<?php

function iniciarSessao(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    session_set_cookie_params([
        'httponly' => true,
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'samesite' => 'Lax',
        'path' => '/',
    ]);

    session_start();
}

function exigirAutenticacao(): void
{
    iniciarSessao();

    if (empty($_SESSION['usuario_id'])) {
        header('Location: ../pages/login.php');
        exit;
    }
}

function usuarioAutenticado(): bool
{
    iniciarSessao();

    return !empty($_SESSION['usuario_id']);
}
