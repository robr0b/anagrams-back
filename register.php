<?php
header("Access-Control-Allow-Origin: *");
require_once "connection.php";
require_once "jwt-token.php";

$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";

function getResponse($email, $password) {
    $conn = getConnection();
    $response = ["success" => true, "message" => []];

    // Email validation

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["success"] = false;
        $response["message"][] = "Email is not in a correct format";
    }

    // Password validation

    if (strlen($password) < 8) {
        $response["success"] = false;
        $response["message"][] = "Password must be at least 8 characters long";
    }
    if (!preg_match("@[A-Z]@", $password))  {
        $response["success"] = false;
        $response["message"][] = "Password must contain an uppercase letter";
    }
    if (!preg_match("@[a-z]@", $password)) {
        $response["success"] = false;
        $response["message"][] = "Password must contain a lowercase letter";
    }

    if (!preg_match("@[0-9]@", $password)) {
        $response["success"] = false;
        $response["message"][] = "Password must contain a number";
    }

    if (!$response["success"]) { // Email or password is in an invalid format
        return json_encode($response);
    }

    // Check if there is a user with this email

    $stmt = $conn->prepare("select * from users where email=:email");
    $stmt->bindValue(":email", $email);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (sizeof($data) > 0) { // Email address already exists
        $response["success"] = false;
        $response["message"][] = "User with this email already exists";
        return json_encode($response);
    }

    $stmt = $conn->prepare("insert into users (email, password_hash)
                                values (:email, :password_hash)");
    $stmt->bindValue(":email", $email);
    $stmt->bindValue(":password_hash", password_hash($password, PASSWORD_DEFAULT));
    $stmt->execute();

    // Getting user id for JWT token

    $stmt = $conn->prepare("select user_id from users where email=:email");
    $stmt->bindValue(":email", $email);
    $stmt->execute();
    $user_id = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]["user_id"];
    $user_data = ["user_id" => $user_id, "email" => $email];
    $response = ["success" => true, "email" => $email, "token" => generateJWTToken($user_data)];
    return json_encode($response);
}

echo getResponse($email, $password);