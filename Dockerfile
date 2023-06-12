# Utilisez une image PHP officielle avec Apache
FROM php:7.4-apache

# Copiez le contenu de l'application PHP dans le répertoire du serveur Apache
COPY ./app /var/www/html

# Installez les dépendances nécessaires
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install -j$(nproc) iconv \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install mysqli pdo_mysql zip

# Activez le module Apache 'rewrite' pour les URL propres
RUN a2enmod rewrite

# Exposez le port 80 pour le trafic HTTP
EXPOSE 80

# Démarrez Apache quand le conteneur est lancé
CMD ["apache2-foreground"]
