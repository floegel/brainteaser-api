dir=`pwd`
curl -sS https://getcomposer.org/installer | php
php composer.phar install
if [ ! -f ${dir}/.env ]; then
    cp ${dir}/.env.example ${dir}/.env
    echo "Created .env file - modify to your needs!"
    exit 0
fi