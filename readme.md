#### NetLogger


###### Setup Instructions

```

# install dependencies
$ composer install && npm install

# build frontend code
$ npm run prod

# setup database (create a database) and add credentials to .env file

$ cp .env.example.com .env && nano .env

DB_DATABASE=netlogger
DB_USERNAME=username
DB_PASSWORD=password

# run migrations
php artisan migrate

# create a virtual host
Create a virtual host and point to it public directory

# add cronjob for laravel scheduler
$ sudo crontab -e -u www-data

# m h  dom mon dow   command
cd /var/www/netlogger && php artisan schedule:run >> /dev/null 2>&1

```

![alt text](https://i.imgur.com/g47qUdh.png)


