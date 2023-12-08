FROM --platform=$BUILDPLATFORM php:8.0.9-apache as builder

CMD ["apache2-foreground"]

FROM builder as dev-envs

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN docker-php-ext-install pdo pdo_mysql

# comment this line and enable the app volume in the compse.yaml to have live updates
# COPY / /var/www/html

CMD ["apache2-foreground"]