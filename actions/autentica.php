<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método não permitido.');
}

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

if ($email === '' || $senha === '') {
    header('Location: ../pages/login.php?erro=credenciais');
    exit;
}

$consulta = $conexao->prepare('SELECT id, nome, email, senha FROM usuarios WHERE email = :email LIMIT 1');
$consulta->execute(['email' => $email]);
$usuario = $consulta->fetch();

if (!$usuario || !password_verify($senha, $usuario['senha'])) {
    header('Location: ../pages/login.php?erro=credenciais');
    exit;
}

iniciarSessao();
session_regenerate_id(true);
$_SESSION['usuario_id'] = (int) $usuario['id'];
$_SESSION['usuario_nome'] = $usuario['nome'];

header('Location: ../pages/index.php');
exit;
