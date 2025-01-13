<?php

require 'vendor/autoload.php';
use \Firebase\JWT\JWT;
require 'config.php';

function generateJWT($id_divisi) {
    $payload = [
        'iss' => 'http://yourdomain.com', // Issuer
        'aud' => 'http://yourdomain.com', // Audience
        'iat' => time(), // Issued at
        'nbf' => time(), // Not before
        'exp' => time() + (60*60), // Expiration time (1 hour)
        'data' => [
            'id_divisi' => $id_divisi
        ]
    ];

    return JWT::encode($payload, SECRET_KEY, 'HS512');
}
?>