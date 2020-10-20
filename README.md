# Installation instruction 

Ensure composor is installed. 
Please note that an exported sql file of the db used in in the project root. 
The development server used XAMPP v3.2.4 with apache and MYSQL.

Navigate to root of the project and enter the following commands into a CLI


// installs project dependencies 

$composer update

// migrates the db if needed

$php artisan migrate

// seeds the db

$php artisan db:seed --class=UserSeeder

// runs unit tests for the API

$php artisan test

// runs server at http://127.0.0.1:8000

$php artisan serve
