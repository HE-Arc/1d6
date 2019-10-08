# 1d6
Allows indecisive groups of people to find a place to eat

# Installation guide

```bash
# Clone the repository
git clone https://github.com/HE-Arc/1d6.git

# Copy the exemple .env file
cp .env.example .env

# Create an encryption key
php artisan key:generate
```

Install a database (like MySQL), fill the config in `.env` (`DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`) and run

```
php artisan migrate
```