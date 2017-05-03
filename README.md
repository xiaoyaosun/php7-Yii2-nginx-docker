[![Build Status](https://travis-ci.org/xiaoyaosun/php7-Yii2-nginx-docker.svg?branch=master)](https://travis-ci.org/xiaoyaosun/php7-Yii2-nginx-docker)

# Nginx and PHP and Yii2.0 for Docker

## Lastest Version
nginx: **1.11.6**   
php:   **7.1.3**

## Docker Hub   
**Nginx-PHP7-Yii2.0:** [https://hub.docker.com/r/xiaoyaosun/nginx-php7-yii2.0/](https://hub.docker.com/r/xiaoyaosun/nginx-php7-yii2.0/)   
   
## Installation
Pull the image from the docker index rather than downloading the git repo. This prevents you having to build the image on every docker host.
```sh
docker pull xiaoyaosun/nginx-php7-yii2.0:latest
```

## Running
To simply run the container:
```sh
docker run --name nginx -p 8092:8092 -d xiaoyaosun/nginx-php7-yii2.0:latest
```
You can then browse to http://\<docker_host\>:8092 to view the default install files.

## Volumes
If you want to link to your web site directory on the docker host to the container run:
```sh
docker run --name php7-Yii2-nginx -d -p 8092:8092 
                        -v /your_code_directory:/data/www 
                        xiaoyaosun/nginx-php7-yii2.0:latest
```

## Enabling SSL
```sh
docker run -d --name=nginx \
-p 80:80 -p 8093:8093 \
-v your_crt_key_files:/usr/local/nginx/conf/ssl \
-e PROXY_WEB=On \
-e PROXY_CRT=your_crt_name \
-e PROXY_KEY=your_key_name \
-e PROXY_DOMAIN=your_domain \
xiaoyaosun/nginx-php7-yii2.0:latest
```

## Enabling Extensions With *.so
Add xxx.ini to folder ```/your_php_extension_ini``` and add xxx.so to folder ```/your_php_extension_file```, then run the command:   
```sh
docker run --name nginx \
-p 8092:8092 -d \
-v /your_php_extension_ini:/usr/local/php/etc/php.d \
-v /your_php_extension_file:/data/phpext \
xiaoyaosun/nginx-php7-yii2.0:latest
```
in xxx.ini, "zend_extension = /data/phpext/xxx.so", the zend_extension must be use ```/data/phpext/```.   

## Enabling Extensions With Source
Also, You can add the source to ```extension.sh```. Example:   
```
#Add extension mongodb
curl -Lk https://pecl.php.net/get/mongodb-1.2.8.tgz | gunzip | tar x -C /home/extension && \
cd /home/extension/mongodb-1.2.8 && \
/usr/local/php/bin/phpize && \
./configure --with-php-config=/usr/local/php/bin/php-config && \
make && make install
```
Add ```mongodb.ini``` to folder ```extini```:   
```
extension=mongodb.so
```

#Add extension redis
curl -Lk https://pecl.php.net/get/redis-3.1.2.tgz | gunzip | tar x -C /home/extension && \
cd /home/extension/redis-3.1.2 && \
/usr/local/php/bin/phpize && \
./configure --with-php-config=/usr/local/php/bin/php-config && \
make && make install
```
Add ```redis.ini``` to folder ```extini```:   
```
extension=redis.so
```

#Add extension ssh2
curl -Lk https://pecl.php.net/get/ssh2-1.0.tgz | gunzip | tar x -C /home/extension && \
cd /home/extension/ssh2-1.0 && \
/usr/local/php/bin/phpize && \
./configure --with-php-config=/usr/local/php/bin/php-config && \
make && make install
```
Add ```ssh2.ini``` to folder ```extini```:   
```
extension=ssh2.so
```

You can see the **[My Home Page](https://www.xiaoyaosun.com)**

## [ChangeLog](changelogs.md)

## Thanks
[Legion](https://www.dwhd.org)  
[Skiychan](https://www.skiy.net)

## Contact Me
```
Author:
   Sunny Wang
Email:
   xiaoyaosun AT qq DOT com
Link:
   http://www.xiaoyaosun.com
```
