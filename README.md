# 1d6
Allows indecisive groups of people to find a place to eat

# Installation guide
Make sure you have a working php (7.2 is recommended) and database (MySql or PostgreSQL should work) installation.

# Clone the repository
```bash
git clone https://github.com/HE-Arc/1d6.git
```

# Nuxt install
Make sure to go into the client folder first

```bash
# Install dependencies
npm i
```


# Laravel
Make sure to go into the server folder first
```bash
# Copy the exemple .env file
cp .env.example .env

# Install php dependencies for your version (if required)
sudo apt-get install php-mbstring
sudo apt-get install php-xml

# Install the first layer of bloat (around 9268 files ~~to display one h1 and 8 links~~)
composer install

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
Run `php artisan serve` for an easy way to serve laravel
Run `npm run dev` to run nuxt

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