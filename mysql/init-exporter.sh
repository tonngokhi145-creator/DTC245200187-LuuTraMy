#!/usr/bin/env bash
set -euo pipefail

cd "$(dirname "$0")/.."

set -a
source ./.env
set +a

docker compose exec -T mysql sh -c \
  'MYSQL_PWD="$MYSQL_ROOT_PASSWORD" mysql -u root' <<SQL
CREATE USER IF NOT EXISTS 'recipe_exporter'@'%'
IDENTIFIED BY '${MYSQL_EXPORTER_PASSWORD}'
WITH MAX_USER_CONNECTIONS 3;

ALTER USER 'recipe_exporter'@'%'
IDENTIFIED BY '${MYSQL_EXPORTER_PASSWORD}';

GRANT PROCESS, REPLICATION CLIENT, SELECT
ON *.* TO 'recipe_exporter'@'%';
SQL

echo "Da tao user recipe_exporter thanh cong."
