<?php

require 'vendor/autoload.php';
use \Firebase\JWT\JWT;
require 'config.php';

function verifyJWT($token) {
    try {
        $decoded = JWT::decode($token, array('HS256'));
        return (array) $decoded->data;
    } catch (Exception $e) {
        return false;
    }
}
?>