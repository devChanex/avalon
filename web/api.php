<?php
header('Content-Type: application/json');

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
