<?php
session_start();
session_destroy();

exit(json_encode(["status" => "success", "message" => "Logged Out Successfully"]));

?>