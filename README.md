# Laravel Stock Managment


## Installation

First clone this repository, install the dependencies, and setup your .env file.

```
git clone https://github.com/Abdulqadr489/StockManagment.git
composer install
cp .env.example .env
```

Then create the necessary database.

```
php artisan db
create database blog
```

And run the initial migrations and seeders.

```
php artisan migrate --seed
```

## Features

- Create and manage branches for stores
- Track inventory (stock) per branch
- Handle item categories and items
- Record sales (with multiple items per sale)
- Manage customers (optional)
- Retrieve sales per branch or all branches
- API secured with Laravel Passport
