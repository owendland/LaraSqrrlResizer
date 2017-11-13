FROM laradock/workspace:1.9-71

USER root

#
#--------------------------------------------------------------------------
# Software's Installation
#--------------------------------------------------------------------------
#
# Installing tools and PHP extentions using "apt"
#

RUN apt-key adv --keyserver hkp://pgp.mit.edu:80 --recv-keys 573BFD6B3D8FBC641079A6ABABF5BD827BD9BF62 \
    && echo "deb http://nginx.org/packages/debian/ jessie nginx" >> /etc/apt/sources.list \
	&& apt-get update \
    && apt-get install -y --no-install-recommends \
        ca-certificates \
		nginx=1.12.2-1~jessie \
		nginx-module-xslt \
		nginx-module-geoip \
		nginx-module-image-filter \
		nginx-module-njs \
		gettext-base \
        libz-dev \
        libjpeg-dev \
        libpng12-dev \
        libssl-dev \
        vim \
        curl \
        apt-transport-https \
        lsb-release \
        python-software-properties \
        supervisor \
	&& add-apt-repository -y ppa:ondrej/php \
	&& apt-get update -y \
	&& apt-get install -y --no-install-recommends \
		php7.1-fpm \
    && rm -r /var/lib/apt/lists/*

#####################################
# Setup web user
#####################################

# Create web user
RUN usermod -u 1001 www-data

#####################################
# Logging
#####################################

# Nginx logs to Docker log collector
RUN ln -sf /dev/stdout /var/log/nginx/access.log && \
	ln -sf /dev/stderr /var/log/nginx/error.log

#####################################
# Config files
#####################################

# Add php-fpm config
ADD build/docker/nginx-php/config/php-fpm/www.conf /etc/php/7.1/fpm/pool.d/www.conf
ADD build/docker/nginx-php/config/php-fpm/php-fpm.conf /etc/php/7.1/fpm/php-fpm.conf
RUN rm /etc/php/7.1/fpm/conf.d/10-opcache.ini

# Add nginx config
ADD build/docker/nginx-php/config/nginx/nginx.conf /etc/nginx/
ADD build/docker/nginx-php/sites-available/* /etc/nginx/conf.d/

# Add supervisor config
ADD build/docker/nginx-php/config/supervisor/supervisor.conf /etc/supervisord.conf

# Make the folder that php-fpm will create the socket in
RUN mkdir -p /var/run/php

WORKDIR /var/www/code

EXPOSE 80

CMD cd ../ && /usr/bin/supervisord -n -c /etc/supervisord.conf