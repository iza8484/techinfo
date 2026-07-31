FROM php:8.2-apache

# Habilita o mod_rewrite do Apache
RUN a2enmod rewrite

# Instala extensoes para o MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copia os arquivos do projeto
COPY . /var/www/html/

# Ajusta as permissoes dos arquivos
RUN chown -R www-data:www-data /var/www/html

# Altera a porta do Apache para usar a variavel $PORT do Railway ao iniciar
CMD sh -c "sed -i 's/80/'\${PORT:-80}'/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf && apache2-foreground"