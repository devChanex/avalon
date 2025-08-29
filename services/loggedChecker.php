<?php
session_start();
if (isset($_SESSION['username'])) {
    exit(json_encode(["status" => "success", "message" => "Logged"]));
} else {
    exit(json_encode(["status" => "success", "message" => "LoggedOut"]));
}

?>