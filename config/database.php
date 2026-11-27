<?php

$arquivoAmbiente = __DIR__ . '/../.env';
if (is_readable($arquivoAmbiente)) {
    foreach (file($arquivoAmbiente, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $linha) {
        $linha = trim($linha);
        if ($linha === '' || str_starts_with($linha, '#') || !str_contains($linha, '=')) {
            continue;
        }

        [$chave, $valor] = explode('=', $linha, 2);
        $chave = trim($chave);
        $valor = trim(trim($valor), "\"'");

        if ($chave !== '' && getenv($chave) === false) {
            putenv($chave . '=' . $valor);
        }
    }
}

$servidor = getenv('DB_HOST') ?: 'localhost';
$usuario = getenv('DB_USER') ?: 'catalogo';
$senha = getenv('DB_PASS') ?: '';
$dbnome = getenv('DB_NAME') ?: 'catalogo';

try {
    $conexao = new PDO(
        "mysql:host=$servidor;dbname=$dbnome;charset=utf8mb4",
        $usuario,
        $senha
    );

    $conexao->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    $conexao->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $conexao->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    error_log($e->getMessage());
    exit("Erro ao conectar ao banco de dados.");
}
