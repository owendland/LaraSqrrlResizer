FROM owendland/nginx-php-laravel:1.0

USER root

COPY composer.json .
COPY composer.lock .
COPY database/ database/

RUN composer install

# Copy in the code
COPY . .

# Recreate the route cache and set the proper permissions
RUN chgrp -R www-data storage bootstrap/cache && \
	chmod -R ug+rwx storage bootstrap/cache