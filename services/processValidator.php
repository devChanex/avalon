<?php
if (!isset($_SESSION['username'])) {
    http_response_code(403);
    exit(json_encode(["error" => "Not authorized"]));

}
?>