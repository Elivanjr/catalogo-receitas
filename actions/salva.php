<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/receitas.php';

exigirAutenticacao();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método não permitido.');
}

$dados = validarDadosReceita($_POST);
if ($dados === null) {
    header('Location: ../pages/cria.php?erro=dados');
    exit;
}

$dados['usuario_id'] = (int) $_SESSION['usuario_id'];
$consulta = $conexao->prepare(
    'INSERT INTO receitas (usuario_id, titulo, categoria, tempo_preparo, ingredientes, modo_preparo)
     VALUES (:usuario_id, :titulo, :categoria, :tempo_preparo, :ingredientes, :modo_preparo)'
);
$consulta->execute($dados);

header('Location: ../pages/index.php?sucesso=cadastrada');
exit;
