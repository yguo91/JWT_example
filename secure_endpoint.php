<?php
// secure_endpoint.php
require_once 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = 'your_secret_key';
$jwt = isset($_COOKIE['AuthToken']) ? $_COOKIE['AuthToken'] : '';

if (!empty($jwt)) {
    try {
        $decoded = JWT::decode($jwt, new Firebase\JWT\Key($key, 'HS256'));
        // Start outputting HTML content
        ?>
        <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Welcome</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 40px;
                    }
                </style>
            </head>
            <body>
                <h1>Welcome, <?php echo htmlspecialchars($decoded->name); ?>!</h1>
                <p>This is a secure page that you have accessed using JWT based authentication.</p>
            </body>
            </html>
        <?php
        
        //show JWT token on page
        //for debugging purposes only
        $wrappedMessage = wordwrap($jwt, 70, "\n", true);
        echo $wrappedMessage;
    } catch (Exception $e) {
        http_response_code(401);
        echo "Access denied: " . $e->getMessage();
    }
} else {
    http_response_code(401);
    echo "Access denied: Missing token";
}
