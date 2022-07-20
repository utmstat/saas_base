https://formulae.brew.sh/formula/php@7.2
https://stackoverflow.com/questions/64684713/update-php-to-7-4-macos-catalina-with-brew
/usr/local/Cellar/
/usr/local/opt/

/usr/local/etc/php/7.4/

brew services start php@7.4

brew link --overwrite php@7.4

sudo a2dismod php5.6
sudo a2enmod php7.4
sudo service apache2 restart

https://getgrav.org/blog/macos-bigsur-apache-multiple-php-versions

/usr/local/php5

https://wpbeaches.com/updating-to-php-versions-7-4-and-8-on-macos-11-big-sur-and-catalina/

