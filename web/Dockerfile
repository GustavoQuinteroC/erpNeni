# Usamos una imagen base con Apache y PHP 8.3
FROM php:8.3-apache

# Instalamos las extensiones necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    unzip curl git zip libonig-dev libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mbstring xml \
    && a2enmod rewrite

# Copiar archivo de configuración personalizada de Apache
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Habilitar el sitio de configuración
RUN a2ensite 000-default.conf

# Copiar los archivos del proyecto Laravel
COPY . /var/www/html/

# Establecer permisos para Laravel (ajustar propiedad y permisos de los archivos)
RUN chown -R www-data:www-data /var/www/html && chmod -R 775 /var/www/html

# Exponer el puerto 80
EXPOSE 80

# Comando por defecto para iniciar Apache
CMD ["apache2-foreground"]
