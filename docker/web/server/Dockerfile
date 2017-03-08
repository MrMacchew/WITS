FROM ubuntu:14.04

MAINTAINER Dustin Woodard <dustin.woodard@gmail.com>

#  Installs Utils and Apache

RUN apt-get -qq update && apt-get install -y \
 apache2 \
 git-core \
 vim \
 curl \
 wget \
 software-properties-common \
 unzip \
&& apt-get clean


ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2


#  Installs PHP   ##############
RUN apt-get update
RUN add-apt-repository -y ppa:ondrej/php

#  Installs PHP   ##############
RUN apt-get update && apt-get install -y --force-yes\
 php5.6 \
 apache2 \
 libapache2-mod-php5.6 \
 php5.6-curl \
 php5.6-gd \
 php5.6-mcrypt \
 mysql-server-5.5 \
 php5.6-mysql\
 php5.6-readline\
 php5.6-simplexml\
 php5.6-xml

RUN a2enmod rewrite

# Enabling mod-xsendfile
RUN apt-get update && apt-get install -y libapache2-mod-xsendfile && a2enmod xsendfile

# Setting document root
RUN mkdir /var/www/html/public/

RUN sed -i "s#.*DocumentRoot /var/www/html#\tDocumentRoot /var/www/html/public#" /etc/apache2/sites-enabled/000-default.conf
RUN sed -i "s#\#ServerName www.example.com#ServerName localhost#" /etc/apache2/sites-enabled/000-default.conf

RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

RUN sed -i "s/disable_functions = .*/disable_functions = /" /etc/php/5.6/cli/php.ini

# Set up php.ini (both cli and apache2)
RUN sed -i "s/.*post_max_size.*/post_max_size = 3G/" /etc/php/5.6/cli/php.ini
RUN sed -i "s/.*post_max_size.*/post_max_size = 3G/" /etc/php/5.6/apache2/php.ini

#
RUN sed -i "s/.*upload_max_filesize.*/upload_max_filesize = 3G/" /etc/php/5.6/cli/php.ini
RUN sed -i "s/.*upload_max_filesize.*/upload_max_filesize = 3G/" /etc/php/5.6/apache2/php.ini

# max_input_time
RUN sed -i "s/.*max_input_time.*/max_input_time = 9000/" /etc/php/5.6/apache2/php.ini
RUN sed -i "s/.*max_input_time.*/max_input_time = 9000/" /etc/php/5.6/apache2/php.ini

# max_file_uploads
RUN sed -i "s/.*max_file_uploads.*/max_file_uploads = 100/" /etc/php/5.6/apache2/php.ini
RUN sed -i "s/.*max_file_uploads.*/max_file_uploads = 100/" /etc/php/5.6/apache2/php.ini

# memory_limit
RUN sed -i "s/.*memory_limit .*/memory_limit = 1G/" /etc/php/5.6/apache2/php.ini
RUN sed -i "s/.*memory_limit .*/memory_limit = 1G/" /etc/php/5.6/apache2/php.ini

# Restarting Apache
RUN service apache2 restart

# Composer is the future. But you knew that did you Nice job.
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

# Correct Time
RUN echo "America/Denver" | sudo tee /etc/timezone
RUN dpkg-reconfigure --frontend noninteractive tzdata

RUN mkdir -p /etc/ssl/server/certs

# Make CERT
RUN openssl req -new -newkey rsa:4096 -days 3652 -nodes -x509 -subj "/C=US/ST=UT/L=Ogden/O=IT/CN=docker.dev" -keyout /etc/ssl/server/certs/server.pem  -out /etc/ssl/server/certs/server.cert

ADD app.conf /etc/apache2/sites-available/

RUN a2ensite app.conf
RUN a2enmod ssl

VOLUME ["/var/www/html/"]

EXPOSE 80
EXPOSE 443

CMD /usr/sbin/apache2ctl -D FOREGROUND
