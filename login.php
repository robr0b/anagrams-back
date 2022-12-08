<?php
header("Access-Control-Allow-Origin: *");
require_once "connection.php";
require_once "jwt-token.php";

$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";

function getResponse($email, $password) {
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