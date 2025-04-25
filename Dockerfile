FROM php:8.3-apache

# เปิด mod_rewrite
RUN a2enmod rewrite

# ติดตั้ง PostgreSQL extensions
RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pgsql pdo_pgsql

# ตั้ง Timezone
RUN echo "date.timezone=Asia/Bangkok" > /usr/local/etc/php/conf.d/timezone.ini

# คัดลอกไฟล์ไปยัง DocumentRoot
COPY ./src /var/www/html

# เปิดพอร์ต 80
EXPOSE 80
