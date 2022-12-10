<?php
header("Access-Control-Allow-Origin: *");
require_once "connection.php";
require_once "jwt-token.php";
require_once "vendor/autoload.php";

$url = $_POST["url"] ?? "";
$email = $_POST["email"] ?? "";
$token = $_POST["token"] ?? "";

function getResponse($url, $email, $token) {
    $user_data = getUserDataFromEmailAndToken($email, $token);
    if (!$user_data) {
        return json_encode(["success" => false, "message" => "bad_token"]);
    }
    if (pathinfo($url)["extension"] !== "txt") {
        return json_encode(["success" => false, "message" => "Please provide a link to a text file"]);
    }
    try {
        $wordbase_words = file_get_contents($url);
        $conn = getConnection();
        $stmt = $conn->prepare("insert into wordbase(wordbase_user_id, wordbase_words)
                                values (:wordbase_user_id, :wordbase_words)
                                on duplicate key update
                                                     wordbase_words=:wordbase_words");
        $stmt->bindValue(":wordbase_words", $wordbase_words);
        $stmt->bindValue(":wordbase_user_id", $user_data["user_id"]);
        $stmt->execute();

        return json_encode(["success" => true, "message" => "Wordbase has been imported successfully!"]);
    }
    catch (Exception $e) {
        return json_encode(["success" => false, "message" => "Could not import wordbase. Try a different one!"]);
    }
}

echo getResponse($url, $email, $token);