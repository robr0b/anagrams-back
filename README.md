This is the backend API for https://github.com/robr0b/anagrams-front
This repository is deployed at https://anagrams-back.herokuapp.com/

To install the dependencies, run:

composer install

To run the app, create a .env file with the following variables:
DB_SERVERNAME
DB_USERNAME
DB_NAME
DB_PASSWORD
JWT_SECRET

Then:

php -S localhost:8000

To run the tests for the anagrams algorithm:

./vendor/bin/phpunit  
