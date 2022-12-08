<?php
//header("Access-Control-Allow-Origin: *");
//require_once "validate-wordbase.php";
//require_once "connection.php";
//require_once "jwt-token.php";
//require_once "vendor/autoload.php";

echo $_ENV["JWT_SECRET"];
echo getenv("JWT_SECRET");
//var_dump(tokenIsValid($_POST["token"]));
