<?php
header("Access-Control-Allow-Origin: *");
require_once "validate-wordbase.php";
require_once "connection.php";
require_once "jwt-token.php";
require_once "vendor/autoload.php";

if (file_exists(".env")) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}
try {
    var_dump(getenv("JWT_SECRET"));
}
catch (Exception $exception) {
    echo "error";
}
//var_dump(tokenIsValid($_POST["token"]));
