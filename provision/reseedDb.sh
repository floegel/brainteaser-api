echo "Reseed database"

dir=`pwd`
. ${dir}/.env

# shorthands, remove carriage returns
dbName=$(echo ${SYMFONY__DB_NAME}|tr -d '\r')
env=$(echo ${SYMFONY_ENV}|tr -d '\r')

if [ $env != "dev" ]; then
    echo "ERROR: Reseed only allowed in dev environment"
    exit 1;
fi

psql -U postgres -q -c "TRUNCATE public.training CASCADE;" ${dbName}
psql -U postgres -q -d ${dbName} -a -f ${dir}/provision/data.sql