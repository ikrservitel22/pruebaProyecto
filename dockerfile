FROM php:8.3-fpm

# Instalar dependencias del sistema (librerías de desarrollo)
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    curl \
    libxml2-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones de PHP
# Aquí es donde ocurre la magia: añadimos 'xml' y 'dom'
RUN docker-php-ext-install pdo pdo_mysql zip xml dom