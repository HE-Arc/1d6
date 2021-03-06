This project is now archived. It was a school project and it is not planned to work on it again in the future.

# 1d6
Allows indecisive groups of people to make a decision


# Installation guide
Make sure you have a working php (7.2 is recommended) and database (MySql or PostgreSQL should work) installation.

# Clone the repository
```bash
git clone https://github.com/HE-Arc/1d6.git
```

# Laravel
```bash
# Copy the exemple .env file
cp .env.example .env

# Install php dependencies for your version (if required)
sudo apt-get install php-mbstring
sudo apt-get install php-xml
# ...

# Install the first layer of bloat (around 9268 files ~~to display one h1 and 8 links~~)
composer install

# If required, run the following command to load the helper file
composer dump-autoload

# Here is the other layer of bloat (~12828 files)
npm install

# Create an encryption key
php artisan key:generate
```

Fill the config in `.env` (`DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`) and run

```
php artisan migrate
```

# Hosting the project
Run `npm run watch-poll` to automatically "compile" vue files when you save them
Run `php artisan serve` for an easy way to serve laravel


# Installing MySql in a docker
If you want a quick way to setup a development database, you can use a docker image:

```bash
# Create docker
sudo docker run --name 1d6-mysql -p 3306:3306 -e MYSQL_ROOT_PASSWORD=<PASSWORD> -d mysql:5.7.28

# Connect to it
sudo docker exec -it 1d6-mysql bash

# Create a database
mysql -p

CREATE DATABASE `laravel`;
```

# Deployment

Once the project has been cloned, modify the following files according to your setup:

- Base API url in resources/js/app.js
- Database configuration in config/database.php

Then, run

```bash
composer install
npm install
npm run production
```
