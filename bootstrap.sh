DBUSER=root
DBPASSWD=root

locale-gen UTF-8
apt-get update
apt-get -y upgrade

apt-get install -y debconf-set-selections
debconf-set-selections <<< "mysql-server mysql-server/root_password password $DBPASSWD"
debconf-set-selections <<< "mysql-server mysql-server/root_password_again password $DBPASSWD"
apt-get install -y mysql-server

apt-get install -y language-pack-en-base
LC_ALL=en_US.UTF-8 add-apt-repository ppa:ondrej/php5-5.6
apt-get install -y apache2 php5 php5-mysql libapache2-mod-php5
apt-get install -y curl git

# curl -sL https://deb.nodesource.com/setup_4.x | bash -
# apt-get install -y nodejs
# npm install -g bower webpack gulp-cli

if ! [ -L /var/www/html ]; then
  rm -rf /var/www/html
  ln -fs /vagrant /var/www/html
fi

VHOST=$(cat <<EOF
<VirtualHost *:80>
    DocumentRoot "/var/www/html"
    <Directory "/var/www/html>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
EOF
)
echo "${VHOST}" > /etc/apache2/sites-available/000-default.conf

curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
cd /vagrant && \
composer install
php ./pagekit install pagekit/blog pagekit/theme-one
# npm install

a2enmod rewrite
service apache2 restart
