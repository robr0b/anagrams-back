<?php
header("Access-Control-Allow-Origin: *");
require_once "connection.php";
require_once "jwt-token.php";

$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";


/**
 * Get response based on user email and password. If user with these credentials exists,
 * generate a JWT token to let the user use the API. Return JSON
 * with success => true, user's email and the token. If user does not exist, return JSON
 * with success => false, and a message saying that the credentials are invalid.
 *
 * @param string $email User's email
 * @param string $password User's password
 *
 *
 * @return string JSON with user data if response is successful, otherwise JSON with error message
 */
function getResponse(string $email, string $password) : string {
    $conn = getConnection();
    $stmt = $conn->prepare("select * from users where email=:email");
    $stmt->bindValue(":email", $email);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (sizeof($data) === 0) {
        return json_encode(["success" => false, "message" => "Email or password is incorrect"]);
    }

    $password_hash = $data[0]["password_hash"];
    if (password_verify($password, $password_hash)) {
        $user_data = ["user_id" => $data[0]["user_id"], "email" => $email];
        return json_encode(["success" => true, "email" => $email, "token" => generateJWTToken($user_data)]);
    }
    return json_encode(["success" => false, "message" => "Email or password is incorrect"]);
}

echo getResponse($email, $password);