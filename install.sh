sudo apt-get install apache2 php unoconv python3-uno 
cp -rf ../Certificate/ /var/www/html
chown -R $USER:www-data /var/www/html/Certificate
chmod -R 755 /var/www/html/Certificate
