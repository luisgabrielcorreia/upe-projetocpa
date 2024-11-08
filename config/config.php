<?php

require_once __DIR__ . '/../vendor/autoload.php'; 

session_start();

$clientID = '970233426627-anv3k76kn0jbr890gu1o75gki92ev94f.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/upe-projetocpa/config/welcome.php'; 

$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

$hostname = "localhost";
$username = "root";
$password = "";
$database = "banco_cpa";

$conn = mysqli_connect($hostname, $username, $password, $database);
$conn->set_charset("utf8");
