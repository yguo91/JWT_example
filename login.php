<?php
// login.php
require_once 'vendor/autoload.php';
use Firebase\JWT\JWT;

$email = 'user@example.com'; // Example user email
$password = 'userPassword'; // Example user password
$key = 'your_secret_key';

$payload = [
    "iss" => "http://example.org", //issuer
    "aud" => "http://example.com", //audience
    "iat" => time(),
    "exp" => time() + (60*60), //one hour expiration
    "sub" => "1234567890",
    "name" => "John Doe",
    "email" => $email,
];

$jwt = JWT::encode($payload, $key, 'HS256'); //HMAC SHA-256 algorithm-symmetric encryption

// Initiate cURL session
$url = 'http://localhost/secure_endpoint.php'; // Adjust the URL as needed
$header = array('Authorization: Bearer ' . $jwt);

// Set the JWT in a cookie
setcookie("AuthToken", $jwt, $payload['exp'], "/", "", true, true); // Secure and HTTPOnly

// Redirect to secure_endpoint.php or another protected page
header('Location: /secure_endpoint.php');
exit();
