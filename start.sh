#!/bin/bash
set -e

# Start PHP-FPM (Apache lui délègue l'exécution PHP)
php-fpm82 -D -y /etc/php82/php-fpm.conf

# Inject PORT into Apache config
sed "s/__PORT__/$PORT/g" /app/apache.conf > /tmp/httpd.conf

# Start Apache in foreground
exec httpd -f /tmp/httpd.conf -DFOREGROUND
