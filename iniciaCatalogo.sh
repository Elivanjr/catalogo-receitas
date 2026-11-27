#!/usr/bin/env bash
set -euo pipefail

PROJECT_DIR="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" && pwd)"

if ! command -v php >/dev/null 2>&1; then
    echo "Erro: PHP não foi encontrado no PATH." >&2
    exit 1
fi

if ! php -m | grep -qi '^pdo_mysql$'; then
    echo "Erro: habilite a extensão pdo_mysql do PHP." >&2
    exit 1
fi

if [[ ! -f "$PROJECT_DIR/.env" ]]; then
    cp "$PROJECT_DIR/.env.example" "$PROJECT_DIR/.env"
    echo "Criei .env a partir de .env.example. Configure as credenciais do banco e rode o script novamente."
    exit 1
fi

echo "Iniciando o catálogo em http://127.0.0.1:8000/ (Ctrl+C para parar)."
echo "O MySQL ou MariaDB precisa estar iniciado e configurado em .env."
exec php -S 127.0.0.1:8000 -t "$PROJECT_DIR"
