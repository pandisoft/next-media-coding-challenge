## next-media-coding-challenge
Next media coding challenge project built using Laravel 8 and Vuejs 2 and tailwindcss

## Install
Clone or download the project 
```sh
composer install
```
or

```sh
composer install --optimize-autoloader --no-dev
```

# Create dummy data
Run the following command to insert dummy data for testing, the database seeder will create 5 categories and 25 product for each category 

```sh
php artisan db:seed --class=DatabaseSeeder
```

# Adding New product
To add new product from CLI run the following command

```sh
php artisan product:new
```

# Testing
To test the product creation run the following command

```sh
php artisan test
```