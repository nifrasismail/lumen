FROM php:7.2.10-fpm

RUN set -x
ARG DEBIAN_FRONTED=noninteractive

# install some bare necessities
RUN apt-get update && apt-get install -y --no-install-recommends \
    apt-utils \
    sudo \
    libmcrypt-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libfreetype6-dev \
    libpq-dev \
    zlib1g-dev \
    libicu-dev \
    libxslt-dev \
    libtidy-dev \
    cron \
    curl \
    wget \
    git \
    unzip \
    ssh \
    vim \
    openssl \
    libssl-dev \
    libcurl4-openssl-dev \
    pkg-config \
    g++ \
    gnupg \
    iproute2 \
    libz-dev
    #libmemcached-dev


# install required extensions
RUN docker-php-ext-install \
    gd \
    xsl \
    zip \
    json \
    iconv \
    curl \
    intl \
    pcntl \
    gd \
    opcache \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    soap \
    zip \
    tidy \
    bcmath

# configure libraries
RUN docker-php-ext-configure gd \
    --enable-gd-native-ttf \
    --with-freetype-dir=/usr/include/freetype2 \
    --with-jpeg-dir=/usr/lib/x86_64-linux-gnu/ \
    --with-libdir=lib/x86_64-linux-gnu \
    --with-openssl=/usr \
    --with-curl \
    && docker-php-ext-configure intl \
    && docker-php-ext-configure hash --with-mhash

# Enable and configure xdebug
RUN pecl install \
    xdebug \
    #memcached \
    mcrypt-1.0.1

RUN docker-php-ext-enable \
    xdebug \
    #memcached \
    mcrypt

# create log folders
RUN mkdir -p /var/log/php-fpm
RUN mkdir -p /var/log/supervisor



# Install Supervisor.
RUN \
  mkdir -p /var/log/supervisor && \
  touch /var/log/supervisor/supervisord.log && \
  apt-get update && \
  apt-get install -y supervisor && \
  rm -rf /var/lib/apt/lists/*


###### Install Nginx
RUN apt-get update \
    && apt-get install -yq nginx

###### Install Composer
RUN curl -s http://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer


# remove default www-data group
RUN userdel www-data

# Add www-data user
RUN groupadd -g 1000 www-data
RUN useradd -r -m -u 1000 www-data -g www-data

# root filesystem
COPY rootfs /

# Fix permissions
RUN chown -Rf www-data:www-data /home/www-data

# cleaning image
RUN apt-get clean \
    && apt-get autoclean \
    && apt-get autoremove --purge

ENTRYPOINT ["entrypoint.sh", "-d"]
# configure app folder
WORKDIR /var/www


