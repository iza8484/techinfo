FROM php:8.2-cli

# Instala extensoes do MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Define o diretorio de trabalho
WORKDIR /var/www/html

# Copia os arquivos do projeto
COPY . .

# Inicia o servidor embutido do PHP apontando para a porta do Railway
CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-8080}"]