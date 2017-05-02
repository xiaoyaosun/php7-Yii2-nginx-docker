FROM centos:7
MAINTAINER SunnyWang <xiaoyaosun@qq.com>

ENV NGINX_VERSION 1.11.6
ENV PHP_VERSION 7.1.3

RUN set -x && \
    yum install -y gcc \
    gcc-c++ \
    autoconf \
    automake \
    libtool \
    make \
    cmake \
	libssh2-devel && \

#Install PHP library
## libmcrypt-devel DIY
    rpm -ivh http://dl.fedoraproject.org/pub/epel/7/x86_64/e/epel-release-7-9.noarch.rpm && \
    yum install -y zlib \
    zlib-devel \
    openssl \
    openssl-devel \
    pcre-devel \
    libxml2 \
    libxml2-devel \
    libcurl \
    libcurl-devel \
    libpng-devel \
    libjpeg-devel \
    freetype-devel \
    libmcrypt-devel \
    openssh-server \
    python-setuptools && \

#Add user
    mkdir -p /data/{www,phpext} && \
    useradd -r -s /sbin/nologin -d /data/www -m -k no www && \

#Download nginx & php
    mkdir -p /home/nginx-php && cd $_ && \
    curl -Lk http://nginx.org/download/nginx-$NGINX_VERSION.tar.gz | gunzip | tar x -C /home/nginx-php && \
    curl -Lk http://cn2.php.net/get/php-$PHP_VERSION.tar.gz/from/this/mirror | gunzip | tar x -C /home/nginx-php && \

#Make install nginx
    cd /home/nginx-php/nginx-$NGINX_VERSION && \
    ./configure --prefix=/usr/local/nginx \
    --user=www --group=www \
    --error-log-path=/var/log/nginx_error.log \
    --http-log-path=/var/log/nginx_access.log \
    --pid-path=/var/run/nginx.pid \
    --with-pcre \
    --with-http_ssl_module \
    --without-mail_pop3_module \
    --without-mail_imap_module \
    --with-http_gzip_static_module && \
    make && make install && \

#Make install php
    cd /home/nginx-php/php-$PHP_VERSION && \
    ./configure --prefix=/usr/local/php \
    --with-config-file-path=/usr/local/php/etc \
    --with-config-file-scan-dir=/usr/local/php/etc/php.d \
    --with-fpm-user=www \
    --with-fpm-group=www \
    --with-mcrypt=/usr/include \
    --with-mysqli \
    --with-pdo-mysql \
    --with-openssl \
    --with-gd \
    --with-iconv \
    --with-zlib \
    --with-gettext \
    --with-curl \
    --with-png-dir \
    --with-jpeg-dir \
    --with-freetype-dir \
    --with-xmlrpc \
    --with-mhash \
    --enable-fpm \
    --enable-xml \
    --enable-shmop \
    --enable-sysvsem \
    --enable-inline-optimization \
    --enable-mbregex \
    --enable-mbstring \
    --enable-ftp \
    --enable-gd-native-ttf \
    --enable-mysqlnd \
    --enable-pcntl \
    --enable-sockets \
    --enable-zip \
    --enable-soap \
    --enable-session \
    --enable-opcache \
    --enable-bcmath \
    --enable-exif \
    --enable-fileinfo \
    --disable-rpath \
    --enable-ipv6 \
    --disable-debug \
    --without-pear && \
    make && make install && \

#Install php-fpm

    #cd /home/nginx-php/php-$PHP_VERSION && \
    #cp php.ini-production /usr/local/php/etc/php.ini && \
    #cp /usr/local/php/etc/php-fpm.conf.default /usr/local/php/etc/php-fpm.conf && \
    #cp /usr/local/php/etc/php-fpm.d/www.conf.default /usr/local/php/etc/php-fpm.d/www.conf && \
	
#Install supervisor
    easy_install supervisor && \
    mkdir -p /var/{log/supervisor,run/{sshd,supervisord}} && \

#Clean OS
    yum remove -y gcc \
    gcc-c++ \
    autoconf \
    automake \
    libtool \
    make \
    cmake \
	libssh2-devel && \
    yum clean all && \
    rm -rf /tmp/* /var/cache/{yum,ldconfig} /etc/my.cnf{,.d} && \
    mkdir -p --mode=0755 /var/cache/{yum,ldconfig} && \
    find /var/log -type f -delete && \
    rm -rf /home/nginx-php && \

#Change Mod from webdir
    chown -R www:www /data/www

#Add supervisord conf
ADD supervisord.conf /etc/

#Create web folder
VOLUME ["/data/www", "/usr/local/nginx/conf/ssl", "/usr/local/nginx/conf/vhost", "/usr/local/php/etc/php.d", "/data/phpext", "/opt/logs/debug"]

#Update nginx config
ADD nginx_conf/ /usr/local/nginx/conf/

# Create pid dir
RUN mkdir -p /opt/logs/run

#Install php-fpm
ADD phpconfig/php.ini /usr/local/php/etc/
ADD phpconfig/php-fpm.conf /usr/local/php/etc/
ADD phpconfig/www.conf /usr/local/php/etc/php-fpm.d/

# Add php file to /data/www
#ADD php_src/ /data/www/
# add a default file -- version.php
ADD version.php /data/www/

ADD extini/ /usr/local/php/etc/php.d/
ADD extfile/ /data/phpext/

# create the log dir
#Add the /opt/logs/nginx dir
RUN mkdir -p /opt/logs/nginx
RUN mkdir -p /opt/logs/php
RUN mkdir -p /opt/logs/normal
RUN mkdir -p /opt/logs/debug
RUN mkdir -p /opt/app/app-assets
RUN mkdir -p /opt/app/runtime
RUN mkdir -p /opt/app/cookie_path
RUN mkdir -p /opt/app/staticfile
RUN mkdir -p /opt/app/wk
RUN chown -R www:www /opt

#Start
ADD start.sh /
RUN chmod +x /start.sh

#Set port
EXPOSE 8092 8093

#Start it
ENTRYPOINT ["/start.sh"]

#Start web server
#CMD ["/bin/bash", "/start.sh"]
