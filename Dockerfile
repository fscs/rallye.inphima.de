FROM php:5.6-fpm-alpine

RUN apk --update --no-cache add nginx && \
  curl -o /etc/nginx/nginx.conf https://raw.githubusercontent.com/nginxinc/docker-nginx/master/stable/alpine/nginx.conf && \
  rm -f /var/log/nginx/access.log /var/log/nginx/error.log && \
  ln -s /dev/stdout /var/log/nginx/access.log && \
  ln -s /dev/stderr /var/log/nginx/error.log && \
  docker-php-ext-install mysqli


COPY . /var/www/html
COPY default.conf /etc/nginx/conf.d/default.conf

RUN rm -f /var/www/html/default.conf && \
  chown -R www-data:www-data /var/www/html
  #a2enmod rewrite


CMD php-fpm -D && nginx -g "daemon off;"
