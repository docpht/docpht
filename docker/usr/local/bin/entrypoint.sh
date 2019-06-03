#!/bin/bash

# Generate a new self signed SSL certificate when none is provided in the volume
if [ ! -f /etc/nginx/ssl/docpht.key  ] || [ ! -f /etc/nginx/ssl/docpht.crt ]
then
    openssl req -x509 -nodes -newkey rsa:2048 -keyout /etc/nginx/ssl/docpht.key -out /etc/nginx/ssl/docpht.crt -subj "/C=GB/ST=London/L=London/O=Self Signed/OU=IT Department/CN=docpht.org"
fi

chown -R nginx:nginx /var/www/app

exec /bin/s6-svscan /etc/services.d
