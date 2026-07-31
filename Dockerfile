FROM php:8.2-apache

# Habilita o mod_rewrite do Apache
RUN a2enmod rewrite

# Instala extensões do MySQL caso seu PHP use PDO/MySQLi
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copia os arquivos do projeto para o diretório do servidor
COPY . /var/www/html/

# Ajusta as permissões dos arquivos
RUN chown -R www-data:www-data /var/www/html

# Expõe a porta 80 do container
EXPOSE 80