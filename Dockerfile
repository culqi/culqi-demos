FROM php:7.4-apache

# Copia los archivos de la aplicación al directorio de trabajo en el contenedor
COPY . /var/www/html/

# Expone el puerto 80 para que pueda ser accesible desde fuera del contenedor
EXPOSE 8080

# Define el comando que se ejecutará al iniciar el contenedor
CMD cd /var/www/html/culqi-php-develop/examples/ && php -S localhost:8080
