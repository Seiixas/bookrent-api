## definição do php
FROM php:8.2
## instalação do composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
  php composer-setup.php && \
  php -r "unlink('composer-setup.php');" && \
  mv composer.phar /usr/local/bin/composer
## instalcão do sym
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash && \
  apt update && \
  apt upgrade && \
  apt install symfony-cli -y
## netcat

RUN apt install netcat-traditional -y && \
  curl -s -o /usr/bin/wait-for https://raw.githubusercontent.com/eficode/wait-for/v2.2.3/wait-for && \
  chmod +x /usr/bin/wait-for
## dependencias zip de instalação da vm
RUN apt-get update && apt-get install -y \
  zlib1g-dev \
  libzip-dev \
  unzip

RUN apt-get install -y libpq-dev \
  && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
  && docker-php-ext-install pdo pdo_pgsql pgsql

RUN docker-php-ext-install pdo pdo_pgsql zip

WORKDIR /usr/app

COPY composer.json /usr/app
RUN composer install

COPY . /usr/app/