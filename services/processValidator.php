<?php
error_reporting(0);
session_start();
if (!isset($_SESSION['username'])) {
    http_response_code(403);
    exit(json_encode(["error" => "Not authorized"]));

}
?>