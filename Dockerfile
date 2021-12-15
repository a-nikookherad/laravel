FROM php:7.3-fpm

# Copy composer.lock and composer.json
#COPY storage/composer.lock composer.json /var/www/

# Set working directory
WORKDIR /var/www

# Set secan.ir DNS
#RUN echo "nameserver 178.22.122.100" >> /etc/resolv.conf
#RUN echo "nameserver  185.51.200.2" >> /etc/resolv.conf



# Install dependencies
RUN apt-get update --fix-missing && apt-get install -y \
    build-essential \
    default-mysql-server \
    libpng-dev \
    libjpeg62-turbo-dev \
    locales \
    jpegoptim optipng pngquant gifsicle \
    vim \
    nano \
    unzip \
    git \
    curl \
    libzip-dev \
    python \
    supervisor


# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install gd pdo_mysql mbstring zip exif pcntl sockets bcmath
RUN docker-php-ext-configure gd --with-gd --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
#RUN docker-php-ext-install sockets
RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

# Install composer
#RUN curl -sS https://owlmd.ir/composer/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www
# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Change current user to www
# Install supervisor
COPY supervisor/supervisord.conf /etc/supervisor/supervisord.conf
COPY supervisor/conf.d /etc/supervisor/conf.d

#CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
# Installing supervisor service and creating directories for copy supervisor configurations
#RUN mkdir -p /var/log/supervisor && mkdir -p /etc/supervisor/conf.d
#ADD supervisor/supervisord.conf /etc/supervisord.conf
#CMD ["supervisord", "-c", "/etc/supervisord.conf"]

USER www
#FROM python:2.7
# Supervisor config
#RUN apt-get install python -y
#RUN curl -sS https://bootstrap.pypa.io/get-pip.py -o get-pip.py
#RUN curl -sS https://bootstrap.pypa.io/get-pip.py | php -- --install-dir=./ --filename=get-pip.py
#RUN python get-pip.py
#RUN pip install supervisor



#RUN supervisorctl reread
#RUN supervisorctl update

# Expose port 9000 and start php-fpm server
EXPOSE 9000
#CMD ["supervisord", "--nodaemon"]
#CMD ["/usr/bin/supervisord"]
CMD ["php-fpm"]
