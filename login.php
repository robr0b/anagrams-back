<?php
header("Access-Control-Allow-Origin: *");
require_once "connection.php";
$conn = getConnection();

//$stmt = $conn->prepare("select * from users where email=:email and password_hash=:password_hash");
echo $_POST["data"];
echo $_POST["email"];
echo $_POST["password"];

