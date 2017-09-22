##### Installation Script #####
# Execute as:
# ./install.sh
# Don't run it with sudo. It'll ask for password whenever it needs.
# Recommended for *Ubuntu.

# Installing packages. May also specify versions of php packages
# e.g. php7.1 php7.1-gd php7.1-xml
sudo apt-get install apache2 php php-gd php-xml unoconv python3-uno 

# Copy the project/cloned repository to /var/www/html/
# Assuming that to be the document root for the Apache web server.
sudo cp -R ../Certificate/ /var/www/html

# Changing ownership. The $USER must not be root.
sudo chown -R $USER:www-data /var/www/html/Certificate

# Changing Permissions.
sudo chmod -R 775 /var/www/html/Certificate

# Running unoconv
unoconv --listener &
