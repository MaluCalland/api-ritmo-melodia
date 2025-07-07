# Dockerfile
# APP SERVER
# Imagem oficial do PHP 8.2 with Apache Distribuição Linux
FROM php:8.2-apache

# Diretório de trabalho dentro do container
WORKDIR /var/www/html

# Instala/atualiza dependências do sistema e depois limpa os pacotes para reduzir o tamanho da imagem
RUN apt-get update && apt-get install -y \
    git unzip curl \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*	

# Habilita módulo rewrite do Apache
RUN a2enmod rewrite

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia o código da aplicação
COPY . .

# Executa o script de build definido no composer.json
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Define APP_URL como argumento de build e ENV
# Argumento e variável de ambiente
ARG APP_ENV=development
ENV APP_ENV=${APP_ENV}

# Executa lógica de server em RUN e gera doc swagger.json em tempo de build
#RUN case "$APP_ENV" in \
#local)       _URL="http://localhost:8001/" ;; \
#*)           _URL="http://localhost/" ;; \
#esac && \
#php ./vendor/bin/openapi src/ --output public/view/docs/swagger.json \
#&& sed -i "s|%_URL%|${_URL}|g" public/view/docs/swagger.json

# Exposição da porta 80
EXPOSE 80