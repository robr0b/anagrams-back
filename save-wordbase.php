<?php
header("Access-Control-Allow-Origin: *");
require_once "connection.php";
require_once "jwt-token.php";
require_once "vendor/autoload.php";

$url = $_POST["url"] ?? "";
$token = $_POST["token"] ?? "";
function getResponse($url, $token) {
    return "";
}

echo getResponse($url, $token);