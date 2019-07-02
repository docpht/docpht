FROM alpine:3.10

VOLUME /var/www/app/src/config
VOLUME /var/www/app/data
VOLUME /var/www/app/pages
VOLUME /etc/nginx/ssl

EXPOSE 80 443

ARG VERSION

RUN apk update && \
    apk add openssl unzip nginx bash ca-certificates s6 curl ssmtp mailx php7 php7-phar php7-curl \
    php7-fpm php7-json php7-zlib php7-xml php7-dom php7-ctype php7-opcache php7-zip php7-iconv \
    php7-mbstring php7-session php7-bcmath php7-fileinfo php7-xmlwriter php7-tokenizer \
    php7-gd php7-mcrypt php7-openssl php7-sockets php7-posix php7-ldap php7-simplexml && \
    rm -rf /var/cache/apk/* && \
    rm -rf /var/www/localhost && \
    rm -f /etc/php7/php-fpm.d/www.conf

ADD . /var/www/app
ADD docker/ /

RUN rm -rf /var/www/app/docker && echo $VERSION > /version.txt

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD []
