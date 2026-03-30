# Utiliser l'image officielle PHP avec Apache
FROM php:8.2-apache

# Definir le repertoire de travail
WORKDIR /var/www/html

# Installer les dependances systeme et l'extension PostgreSQL pour PHP
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Activer le module Apache Rewrite pour .htaccess
RUN a2enmod rewrite

# Copier les fichiers du projet
COPY . .

# Donner les permissions appropriees
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/public/uploads

# Configurer Apache pour servir depuis le repertoire public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Exposer le port 80
EXPOSE 80

# Demarrer Apache
CMD ["apache2-foreground"]
