<?php
header("Access-Control-Allow-Origin: *");
require_once "utils/validate-wordbase.php";
require_once "utils/connection.php";
require_once "utils/jwt-token.php";
require_once "vendor/autoload.php";


var_dump(tokenIsValid($_POST["token"]));
