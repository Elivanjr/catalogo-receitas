<?php

function listarReceitas(PDO $conexao, int $usuarioId): array
{
    $consulta = $conexao->prepare(
        'SELECT id, titulo, categoria, tempo_preparo, ingredientes, modo_preparo
         FROM receitas WHERE usuario_id = :usuario_id ORDER BY id DESC'
    );
    $consulta->execute(['usuario_id' => $usuarioId]);

    return $consulta->fetchAll();
}

function buscarReceita(PDO $conexao, int $usuarioId, int $receitaId): ?array
{
    $consulta = $conexao->prepare(
        'SELECT id, titulo, categoria, tempo_preparo, ingredientes, modo_preparo
         FROM receitas WHERE id = :id AND usuario_id = :usuario_id LIMIT 1'
    );
    $consulta->execute(['id' => $receitaId, 'usuario_id' => $usuarioId]);
    $receita = $consulta->fetch();

    return $receita ?: null;
}

function validarDadosReceita(array $dados): ?array
{
    $titulo = trim($dados['titulo'] ?? '');
    $categoria = $dados['categoria'] ?? '';
    $tempo = filter_var($dados['tempo_preparo'] ?? null, FILTER_VALIDATE_INT);
    $ingredientes = trim($dados['ingredientes'] ?? '');
    $modoPreparo = trim($dados['modo_preparo'] ?? '');
    $categorias = ['Doce', 'Salgado', 'Bebida'];

    if (!preg_match('/^.{1,150}$/us', $titulo) || !in_array($categoria, $categorias, true)
        || $tempo === false || $tempo < 1 || $ingredientes === '' || $modoPreparo === '') {
        return null;
    }

    return [
        'titulo' => $titulo,
        'categoria' => $categoria,
        'tempo_preparo' => $tempo,
        'ingredientes' => $ingredientes,
        'modo_preparo' => $modoPreparo,
    ];
}
