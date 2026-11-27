<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/receitas.php';

exigirAutenticacao();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método não permitido.');
}

$receitaId = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
$dados = validarDadosReceita($_POST);

if ($receitaId === false || $receitaId < 1 || $dados === null) {
    header('Location: ../pages/index.php?erro=dados');
    exit;
}

$dados['id'] = $receitaId;
$dados['usuario_id'] = (int) $_SESSION['usuario_id'];
$consulta = $conexao->prepare(
    'UPDATE receitas
     SET titulo = :titulo, categoria = :categoria, tempo_preparo = :tempo_preparo,
         ingredientes = :ingredientes, modo_preparo = :modo_preparo
     WHERE id = :id AND usuario_id = :usuario_id'
);
$consulta->execute($dados);

header('Location: ../pages/index.php?sucesso=atualizada');
exit;
