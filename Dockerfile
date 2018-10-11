FROM php:7.2-apache
RUN docker-php-ext-install mbstring pdo pdo_mysql
COPY . /var/www/html/
#FROM centos
#RUN yum install httpd php mbstring pdo pdo_mysql -y;
#COPY . /var/www/html/
