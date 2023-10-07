<?php
// Avoid CORS policy regulation
header('Access-Control-Allow-Origin: *');
// as we are in API, we return JSON
header('Content-Type: application/json');

// forbid all HTTP verbs appart POST
if($_SERVER['REQUEST_METHOD'] != 'POST'){
    http_response_code(405);
    echo json_encode(['message' => 'Méthode non autorisé.']);
    exit;
}

// get server headers and extract token if it exists
if(isset($_SERVER['Authorization'])){
        $token = trim($_SERVER['Authorization']);
}elseif(isset($_SERVER['HTTP_AUTHORIZATION'])){
    $token = trim($_SERVER['HTTP_AUTHORIZATION']);
}elseif(function_exists('apache_request_headers')){
    $requestHeaders = apache_request_headers();
    if(isset($requestHeaders['Authorization'])){
        $token = trim($requestHeaders['Authorization']);
    }
}

// check that authorization string begins with 'Bearer ...'
if(!isset($token) || !preg_match('/Bearer\s(\S+)/',$token,$matches)){
    http_response_code(400);
    echo json_encode((['message' => 'Token introuvable']));
    exit;
}

// replace 'Bearer fbcxgbxbbvc' to extract JUST the token value (string)
$token = str_replace('Bearer ','',$token);

require_once('secret.php');
require_once('token.php');

$jwt = new JWToken();

// check validity
if(!$jwt->isValid($token)){
    http_response_code(400);
    echo json_encode((['message' => 'Token contient des caractéres invalides']));
    exit;
}

// check token signature
if(!$jwt->verifyToken($token, SECRET)){
    http_response_code(403);
    echo json_encode((['message' => 'le token est invalide']));
    exit;
}

// check expirationDate
if($jwt->isExpired($token)){
    http_response_code(403);
    echo json_encode((['message' => 'le token a expiré']));
    exit;
}

echo json_encode($jwt->getPayload($token));