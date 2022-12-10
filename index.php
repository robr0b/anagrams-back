<?php
header("Access-Control-Allow-Origin: *");
require_once "connection.php";
require_once "jwt-token.php";

$word = $_GET["word"] ?? "";
$email = $_GET["email"] ?? "";
$token = $_GET["token"] ?? "";


/**
 * Find anagrams based on a provided word and a provided wordbase
 *
 * @param string $word The word to find anagrams for
 * @param array $wordbase_words The wordbase from which to look for anagrams
 *
 *
 * @return array Anagrams for the given word
 */
function findAnagrams(string $word, array $wordbase_words) : array {

    $wordbase_hashmap = [];

    foreach ($wordbase_words as $wordbase_word) {

        $sorted_word_array = mb_str_split(trim($wordbase_word));
        sort($sorted_word_array);

        $sorted_word_str = join($sorted_word_array);

        if (!array_key_exists($sorted_word_str, $wordbase_hashmap)) {

            $wordbase_hashmap[$sorted_word_str] = [$wordbase_word];
        }
        else {
            $wordbase_hashmap[$sorted_word_str][] = $wordbase_word;
        }
    }


    $sorted_user_word_array = mb_str_split($word);
    sort($sorted_user_word_array);

    $sorted_user_word_str = join($sorted_user_word_array);

    if (array_key_exists($sorted_user_word_str, $wordbase_hashmap)) {
        return $wordbase_hashmap[$sorted_user_word_str];
    }
    return ["This word does not have any anagrams. Try a different one!"];
}

function getResponse($word, $email, $token) {
    $user_data = getUserDataFromEmailAndToken($email, $token);
    if (!$user_data) {
        return json_encode(["success" => false, "message" => "bad_token"]);
    }

    $conn = getConnection();
    $stmt = $conn->prepare("select wordbase_words from wordbase
                            where wordbase_user_id = :user_id");
    $stmt->bindValue(":user_id", $user_data["user_id"]);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (sizeof($result) !== 1) {
        return json_encode(["success" => false, "message" => "Import a wordbase first!"]);
    }

    $wordbase_words = preg_split('/\r\n|\r|\n/', $result[0]["wordbase_words"]);

    return json_encode(["success" => true, "anagrams" => findAnagrams($word, $wordbase_words)]);
}

echo getResponse($word, $email, $token);