#!/bin/sh
#########################################################################
# File Name: extension.sh
# Author: Sunny Wang
# Email:  xiaoyaosun@qq.com
# Version:
# Created Time: 2017/04/13
#########################################################################

#Add extension xdebug
#curl -Lk https://github.com/xdebug/xdebug/archive/XDEBUG_2_4_0RC3.tar.gz | gunzip | tar x -C /home/extension && \
#cd /home/extension/xdebug-XDEBUG_2_4_0RC3 && \
#/usr/local/php/bin/phpize && \
#./configure --enable-xdebug --with-php-config=/usr/local/php/bin/php-config && \
#make && make install

#Add extension mongodb
#curl -Lk https://pecl.php.net/get/mongodb-1.2.8.tgz | gunzip | tar x -C /home/extension && \
#cd /home/extension/mongodb-1.2.8 && \
#/usr/local/php/bin/phpize && \
#./configure --with-php-config=/usr/local/php/bin/php-config && \
#make && make install

#Add extension ssh2
curl -Lk https://pecl.php.net/get/ssh2-1.0.tgz | gunzip | tar x -C /home/extension && \
cd /home/extension/ssh2-1.0 && \
/usr/local/php/bin/phpize && \
./configure --with-php-config=/usr/local/php/bin/php-config && \
make && make install

#Add extension redis
curl -Lk https://pecl.php.net/get/redis-3.1.2.tgz | gunzip | tar x -C /home/extension && \
cd /home/extension/redis-3.1.2 && \
/usr/local/php/bin/phpize && \
./configure --with-php-config=/usr/local/php/bin/php-config && \
make && make install
