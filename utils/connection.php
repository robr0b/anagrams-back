<?php

function getConnection() : PDO {
    $servername = "eu-cdbr-west-03.cleardb.net";
    $dbname = "heroku_109a4d54ce8ea34";
    $username = "bede7a339b4aa5";
    $password = "3b2a0345";

    $address = sprintf('mysql:host=%s;port=3306;dbname=%s',
        $servername, $dbname);

    return new PDO($address, $username, $password);
}