FROM ubuntu:latest

LABEL MAINTAINER="Justin Seidel <justin@heia.kim>"

RUN apt update -q
RUN DEBIAN_FRONTEND=noninteractive apt install -y \
  apt-transport-https \
  lsb-release \
  software-properties-common \
  gnupg2 \
  curl \
  ca-certificates \
  ubuntu-keyring \
  libzip-dev \
  libicu-dev \
  libcurl4-openssl-dev \
  git \
  zip \
  unzip \
  nodejs

# Add php repository
RUN add-apt-repository ppa:ondrej/php

# Add Nginx repository
RUN add-apt-repository ppa:ondrej/nginx-mainline

# Update package lists and install Nginx
RUN apt update -q

# Install php
RUN DEBIAN_FRONTEND=noninteractive apt install -y \
  nginx \
  php8.3 \
  php8.3-cli \
  php8.3-fpm \
  php8.3-common \
  php8.3-bz2 \
  php8.3-curl \
  php8.3-mbstring \
  php8.3-intl \
  php8.3-mysql

RUN nginx -v

RUN rm -f /var/log/nginx/access.log /var/log/nginx/error.log && \
    ln -sf /dev/stdout /var/log/nginx/access.log && \
    ln -sf /dev/stderr /var/log/nginx/error.log

WORKDIR /data

COPY . .

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN chmod 755 /usr/local/bin/composer
RUN composer install
RUN composer dump-autoload

# Create a safe user
RUN useradd -m love
RUN chown love -R public storage

# USER love

EXPOSE 80

ENTRYPOINT ["/data/docker/dev/entrypoint.sh"]