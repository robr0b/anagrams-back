<?php
require_once "vendor/autoload.php";
use Dotenv\Dotenv;

// If the app is run locally, load the data from .env file.
// Heroku does not need that to make its Config vars accessible

if (file_exists(".env")) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

function getConnection() : PDO {
    $servername = $_ENV["DB_SERVERNAME"];
    $dbname = $_ENV["DB_NAME"];
    $username = $_ENV["DB_USERNAME"];
    $password = $_ENV["DB_PASSWORD"];

    $address = sprintf('mysql:host=%s;port=3306;dbname=%s',
        $servername, $dbname);

    return new PDO($address, $username, $password);
}