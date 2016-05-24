echo "Setup postgres database and user"

dir=`pwd`
. ${dir}/.env

# shorthands, remove carriage returns
dbName=$(echo ${SYMFONY__DB_NAME}|tr -d '\r')
dbUser=$(echo ${SYMFONY__DB_USER}|tr -d '\r')
dbPass=$(echo ${SYMFONY__DB_PASS}|tr -d '\r')

psql -U postgres -c "DROP DATABASE IF EXISTS ${dbName};"
psql -U postgres -c "DROP USER IF EXISTS ${dbUser};"

psql -U postgres -c "CREATE USER ${dbUser} WITH PASSWORD '${dbPass}';"
psql -U postgres -c "CREATE DATABASE ${dbName};"
psql -U postgres -c "GRANT ALL PRIVILEGES ON DATABASE ${dbName} TO ${dbUser};"

# Install uuid-ossp extension in order to use uuid functions
psql -U postgres -c "DROP EXTENSION IF EXISTS "\""uuid-ossp"\"";" ${dbName}
psql -U postgres -c "CREATE EXTENSION "\""uuid-ossp"\"" WITH SCHEMA public;" ${dbName}

echo "Created database ${dbName} and user ${dbUser}"

php ${dir}/app/console doctrine:migrations:migrate --no-interaction


