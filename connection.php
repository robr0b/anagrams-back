<?php
require_once "vendor/autoload.php";
echo $_ENV["DB_SERVERNAME"];
function getConnection() : PDO {
    $servername = $_ENV["DB_SERVERNAME"];
    $dbname = $_ENV["DB_NAME"];
    $username = $_ENV["DB_USERNAME"];
    $password = $_ENV["DB_PASSWORD"];

    $address = sprintf('mysql:host=%s;port=3306;dbname=%s',
        $servername, $dbname);

    return new PDO($address, $username, $password);
}