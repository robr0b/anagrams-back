<?php
header("Access-Control-Allow-Origin: *");
require_once "connection.php";
$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";

$conn = getConnection();
$stmt = $conn->prepare("select * from users where email=:email");
$stmt->bindValue(":email", $email);
$result = $stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($data as $row) {
    if (password_verify($password, $row["password_hash"])) {
        $response = array("success" => true);
        echo json_encode($response);
    }
}
//$stmt = $conn->prepare("select * from users where email=:email and password_hash=:password_hash");


