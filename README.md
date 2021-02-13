# next-media-coding-challenge
Next media coding challenge project built using Laravel 8 and Vuejs 2 and Tailwind css

# Live demo 
https://nextmedia.pandisoft.com/

# Installation
* Clone or download the project 

* Run the following command to install vendors
    ```sh
    composer install
    ```
* Run the migration
     ```sh
    php artisan migrate
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