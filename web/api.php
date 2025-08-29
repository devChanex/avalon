<?php
header('Content-Type: application/json');
// Only allow requests from this origin
$isLocal = false;
$allowedOrigin = "https://system.avalonwoundcare.ph";
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

// Check if request comes from allowed origin
if (($origin === $allowedOrigin && $_SERVER['REQUEST_METHOD'] === 'POST') || $isLocal) {
    header("Access-Control-Allow-Origin: $origin");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
} else {
    http_response_code(403);
    echo json_encode(["status" => "error", "message" => "Forbidden Access"]);
    exit;
}

// Decide which service to run
$service = $_POST['service'] ?? null;
// echo 'Service: ' . $service; // Debug line to check the service value
switch ($service) {
    case '':
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Invalid service"]);
        exit;
    case null:
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Invalid service"]);
        exit;

    default:
        require __DIR__ . '/../services/' . $service . '.php';
        exit;
}
