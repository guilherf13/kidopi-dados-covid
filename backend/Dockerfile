FROM php:8.3-fpm

# Cria o usuário
ARG user=gui
ARG uid=1000

# Instala as dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    zip \
    unzip \
    libssl-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libzip-dev \
    libxml2-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala as extensões do PHP que são utilizadas pelo Laravel
RUN docker-php-ext-install mbstring exif pcntl bcmath gd sockets pdo_mysql zip

# Instala a extensão do Redis para PHP via PECL
RUN pecl install redis \
    && docker-php-ext-enable redis

# Baixa o Composer na versão mais recente para o container
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Cria o usuário do sistema para rodar o Composer e comandos Artisan
RUN useradd -G www-data,root -u $uid -d /home/$user $user \
    && mkdir -p /home/$user/.composer \
    && chown -R $user:$user /home/$user

RUN chmod +x /usr/local/bin/php

# Define o diretório de trabalho
WORKDIR /var/www

# Copia a customização de configuração do PHP
COPY ./docker/php/custom.ini /usr/local/etc/php/conf.d/custom.ini

USER $user