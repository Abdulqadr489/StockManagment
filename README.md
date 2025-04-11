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


- register / login 
- Category management
- Item management
- Brunch management
- Customers management
- Record sales (with multiple items per sale and per brunch)
- Record transfer from wearhouse to stock (with multiple items)
- Retrieve sales per branch or all branches
- API secured with Laravel Passport
