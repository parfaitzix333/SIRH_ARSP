#!/usr/bin/env sh
set -eu

cd "$(dirname "$0")"
PHP_INI_SCAN_DIR=":$PWD/php/conf.d" exec php artisan serve --no-reload "$@"
