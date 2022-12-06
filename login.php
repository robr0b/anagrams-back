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
foreach ($data as $row) {
    if (password_verify($password, $row["password_hash"])) {
        $data = ["user_id" => $row["user_id"], "email" => $row["email"]];
        $payload = [$data];
        $secret = "Firebase JWT secret";
        $token = JWT::encode($payload, $secret, "HS256");
        echo json_encode(["success" => true, "email" => $email, "token" => $token]);
    }
    else {
        echo json_encode(["success" => false, "message" => "Email or password is incorrect"]);
    }
}

