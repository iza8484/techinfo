FROM php:8.2-apache

# Habilita o mod_rewrite
RUN a2enmod rewrite

# Instala extensões MySQL caso precise
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copia os arquivos da aplicação
COPY . /var/www/html/

# Ajusta permissões
RUN chown -R www-data:www-data /var/www/html

# Configura o Apache para escutar na porta que o Railway definir ($PORT)
CMD sed -i "s/80/${PORT:-80}/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf && apache2-foreground
2. Salve e envie para o GitHub via Terminal: