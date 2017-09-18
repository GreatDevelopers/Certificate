sudo apt-get install apache2 php unoconv python3-uno php-xml php-gd libapache2-mod-php
sudo cp -rf ../Certificate/ /var/www/html
sudo chown -R $USER:www-data /var/www/html
sudo chmod -R 775 /var/www/html
