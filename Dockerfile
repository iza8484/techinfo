FROM php:8.2-apache

# Habilita o mod_rewrite
RUN a2enmod rewrite

# Instala extensoes para o MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copia os arquivos do projeto
COPY . /var/www/html/

# Ajusta as permissoes dos arquivos
RUN chown -R www-data:www-data /var/www/html