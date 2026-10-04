#!/usr/bin/env sh
set -eu

cd "$(dirname "$0")"
exec php \
	-d upload_max_filesize=15M \
	-d post_max_size=80M \
	-d memory_limit=256M \
	-d max_input_time=300 \
	-d max_execution_time=300 \
	artisan serve "$@"
