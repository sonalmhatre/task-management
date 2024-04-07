# task-management

Please check the official laravel installation guide for server requirements before you start. Official Documentation

Alternative installation is possible without local dependencies relying on Docker.

Clone the repository

git clone git@github.com:gothinkster/laravel-realworld-example-app.git

Switch to the repo folder

cd laravel-realworld-example-app

Install all the dependencies using composer

composer install

php artisan key:generate

Run the database migrations (Set the database connection in .env before migrating)

php artisan migrate

Start the local development server

php artisan serve

You can now access the server at http://localhost:8000


<b>Here use Passport plugin for API Authentication purpose</b>

Need to Create a client for issuing access tokens
Use Below command

<h4>php artisan passport:client --personal</h5>

Database seeding
Open the UserSeeder and fields are added

database/seeds/UserSeeder.php
Run the database seeder and you're done

php artisan db:seed --class=UserSeeder
