sudo apt-get install apache2 php unoconv python3-uno php-xml
cp -rf ../Certificate/ /var/www/html
chown -R $USER:www-data /var/www/html
chmod -R 775 /var/www/html
