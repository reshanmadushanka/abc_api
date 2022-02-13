# ABC CRM api

## Installation

Clone the repository

    git clone https://github.com/reshanmadushanka/abc_api.git

Switch to the repo folder

    cd abc_api

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

## Database seeding

     php artisan db:seed --class=UserTableSeeder 

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

## Default user credentials

User Name - admin@admin.com

Password - password

## Api Documentation Swagger

get yml file from https://github.com/reshanmadushanka/abc_api/blob/main/ABC_CRM.yaml 

and render through  https://editor.swagger.io/


