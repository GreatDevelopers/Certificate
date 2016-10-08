apt-get install apache2 
apt-get install php5 
apt-get install unoconv
apt-get install python3-uno 
cp -rf ../Certificate/ /var/www/html
cd /var/www/html
chown -R $USER:www-data /var/www/html/Certificate
chmod -R 755 /var/www/html/Certificate
