echo "Start provisioning"

echo "Patch sources.list for PHP7"
cp /vagrant/provision/files/etc/apt/sources.list /etc/apt/sources.list

echo "Add the GPG key"
wget --quiet https://www.dotdeb.org/dotdeb.gpg
sudo apt-key add dotdeb.gpg

echo "Install packages"
DEBIAN_FRONTEND=noninteractive apt-get update -y
DEBIAN_FRONTEND=noninteractive apt-get install -y make postgresql postgresql-contrib nginx \
    php7.0 php7.0-xdebug php7.0-cli php7.0-pgsql php7.0-fpm php7.0-curl php7.0-intl php7.0-mcrypt php7.0-apc \

echo "Copy and link configs"
# nginx
cp /vagrant/provision/files/etc/nginx/sites-available/site.conf /etc/nginx/sites-available/
rm -f /etc/nginx/sites-enabled/default
rm -f /etc/nginx/sites-enabled/site.conf
ln -s /etc/nginx/sites-available/site.conf /etc/nginx/sites-enabled

# php7
mkdir -p /etc/php/7.0/fpm/conf.d
cp /vagrant/provision/files/etc/php/7.0/fpm/conf.d/* /etc/php/7.0/fpm/conf.d

# postgresql
# allow network access for administration purposes
# in postgresql.conf, set listen_addresses = '*'
# add 'host all dev all password' to pg_hba.conf - also trust local connections
cp /vagrant/provision/files/etc/postgresql/9.4/main/* /etc/postgresql/9.4/main/

# fix permissions
sed -i 's/user = www-data/user = vagrant/g' /etc/php/7.0/fpm/pool.d/www.conf
sed -i 's/group = www-data/group = vagrant/g' /etc/php/7.0/fpm/pool.d/www.conf

echo "Restart services"
service nginx restart
service php7.0-fpm restart
service postgresql restart