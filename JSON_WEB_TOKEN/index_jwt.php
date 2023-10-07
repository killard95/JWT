<?php

require_once("secret.php");
include("token.php");

$header = [
    'typ' => 'JWT',
    'alg' => 'HS256'
];

$payload = [
    'user_id' => '345',
    'role' => 'admin',
    'info' => 'blablu',
];

// $b64head = base64_encode(json_encode($header));
// $b64pay = base64_encode(json_encode($payload));
// $b64secret = base64_encode(SECRET);


// $b64head = str_replace(['+', '/', '='], ['-', '_', ''], $b64head);
// $b64pay = str_replace(['+', '/', '='], ['-', '_', ''], $b64pay);

// echo $b64head."<br>";
// echo $b64pay."<br>";
// $signature = hash_hmac('sha256', $b64head . '.' . $b64pay, $b64secret, true);

// $b64signature = base64_encode($signature);
// $b64signature = str_replace(['+', '/', '='], ['-', '_', ''], $b64signature);

// $jwt = $b64head . '.' . $b64pay . '.' . $b64signature;

// echo $jwt;

// $tokenTest = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiMzQ1Iiwicm9sZSI6ImFkbWluIiwiaW5mbyI6ImJsYWJsdSIsImlhdCI6MTY4MzAzNTcyOCwiZXhwIjoxNjgzMDM1NzU4fQ.ESDgR8kXX2zWJVsgQ35j-368FOjG5R4UQi1545VjmCY";
$tok = new JWToken();
$jwt = $tok->generate($header, $payload, SECRET);
echo $jwt;
// $verif = $tok->verifyToken($tokenTest, SECRET);
// $verif = $tok->isExpired($tokenTest);
// var_dump($verif);
