#!/bin/bash
set -x

echo "Waiting for database..."

while ! nc -z ${DATABASE_HOST} 3306;do
    sleep 0.1
done


echo "Database started"
python /usr/src/myapp/manage.py run -h 0.0.0.0 -p 8080
