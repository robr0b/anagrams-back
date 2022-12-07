<?php
require_once "vendor/autoload.php";
require_once "connection.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

const SECRET = "my-firebase-secret-5000";


function generateJWTToken($user_data): string {
    $payload = ["exp" => time() + 1200,
        "data" => $user_data];

    return JWT::encode($payload, SECRET, "HS256");
}

function tokenIsValid($token) : bool {
    try {
        $decoded_token = JWT::decode($token, new Key(SECRET, "HS256"));
    } catch (Exception $e) {
        return false;
    }
    if ($decoded_token->exp < time()) {
        return false;
    }
    $conn = getConnection();
    $stmt = $conn->prepare("select * from users where user_id=:user_id and email=:email");
    $stmt->bindValue(":user_id", $decoded_token->data->user_id);
    $stmt->bindValue(":email", $decoded_token->data->email);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (sizeof($result) !== 1) {
        return false;
    }
    return $result[0]["user_id"] == $decoded_token->data->user_id &&
            $result[0]["email"] == $decoded_token->data->email;
}