#!/usr/bin/env bash
# Backup database MySQL Pasar.ID ke file SQL (jalankan dari host, container db harus jalan)
set -e

BACKUP_DIR="./backups"
mkdir -p "$BACKUP_DIR"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
FILE="$BACKUP_DIR/pasar_id_$TIMESTAMP.sql"

# Ambil kredensial dari .env (fallback ke default docker-compose)
DB_USER="${MYSQL_USER:-pasar_user}"
DB_PASS="${MYSQL_PASSWORD:-pasar_password}"
DB_NAME="${MYSQL_DATABASE:-pasar_id}"

echo "=> Backup $DB_NAME -> $FILE"
docker compose exec -T db \
  mysqldump -u"$DB_USER" -p"$DB_PASS" "$DB_NAME" > "$FILE"

echo "=> Selesai: $(wc -c < "$FILE") bytes"
