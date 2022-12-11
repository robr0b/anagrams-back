<?php
require_once "vendor/autoload.php";
require_once "connection.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use Dotenv\Dotenv;

// If the app is run locally, load the data from .env file.
// Heroku does not need that to make its Config vars accessible

if (file_exists(".env")) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

/**
 * Generate JWT token based on user data
 *
 * @param array $user_data Array with user id and email
 *
 *
 * @return string JWT token
 */

function generateJWTToken(array $user_data): string {
    $payload = ["exp" => time() + 1200, // token is valid for 20 minutes
        "data" => $user_data];

    return JWT::encode($payload, $_ENV["JWT_SECRET"], "HS256");
}


/**
 * Get the user data if their token is valid and user exists in database. Otherwise, return false
 *
 * @param string $email The email that the user has provided via their request
 * @param string $token HThe token that the user has provided via their request
 *
 *
 * @return array | false User data / bool(false) depending on the input
 */
function getUserDataFromEmailAndToken(string $email, string $token): array|bool
{

    try {
        $decoded_token = JWT::decode($token, new Key($_ENV["JWT_SECRET"], "HS256"));
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
    if ($decoded_token->data->user_id !== $result[0]["user_id"] ||
        $decoded_token->data->email !== $result[0]["email"] ||
        $decoded_token->data->email !== $email) {
        return false;
    }
    return $result[0];
}