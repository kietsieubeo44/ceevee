# Sử dụng một image cơ bản với Apache và PHP
FROM php:7.4-apache

# Thiết lập thư mục làm việc
WORKDIR /var/www/html

# Sao chép tất cả các file từ thư mục cục bộ vào thư mục làm việc trong container
COPY . .

# Thiết lập các quyền truy cập cho thư mục và file
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

# Mở cổng 80 để truy cập web
EXPOSE 80

# Lệnh khởi chạy khi container được khởi động
CMD ["apache2-foreground"]
