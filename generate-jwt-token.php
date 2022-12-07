<?php
require_once "vendor/autoload.php";

use Firebase\JWT\JWT;

function generateJWTToken($user_data): string {
    $payload = ["exp" => time() + 1200,
        "data" => $user_data];
    $secret = "Firebase JWT secret";
    return JWT::encode($payload, $secret, "HS256");
}
