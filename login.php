<?php
header("Access-Control-Allow-Origin: *");
require_once "connection.php";
require_once "vendor/autoload.php";
$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";

use Firebase\JWT\JWT;

$conn = getConnection();
$stmt = $conn->prepare("select * from users where email=:email");
$stmt->bindValue(":email", $email);
$result = $stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (sizeof($data) === 0) {
    echo json_encode(["success" => false, "message" => "Email or password is incorrect"]);
}
else {
    $user_data = $data[0];
    if (password_verify($password, $data[0]["password_hash"])) {
        $response_data = ["user_id" => $user_data["user_id"], "email" => $user_data["email"]];
        $payload = ["exp" => time() + 1200,
            "data" => $response_data];
        $secret = "Firebase JWT secret";
        $token = JWT::encode($payload, $secret, "HS256");
        echo json_encode(["success" => true, "email" => $email, "token" => $token]);
    }
    else {
        echo json_encode(["success" => false, "message" => "Email or password is incorrect"]);
    }
}