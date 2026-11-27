<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';

exigirAutenticacao();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método não permitido.');
}

$receitaId = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
if ($receitaId === false || $receitaId < 1) {
    header('Location: ../pages/index.php?erro=id');
    exit;
}

$consulta = $conexao->prepare('DELETE FROM receitas WHERE id = :id AND usuario_id = :usuario_id');
$consulta->execute([
    'id' => $receitaId,
    'usuario_id' => (int) $_SESSION['usuario_id'],
]);

header('Location: ../pages/index.php?sucesso=excluida');
exit;
