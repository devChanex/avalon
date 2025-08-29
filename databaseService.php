<?php

// Allow requests from your frontend
header("Access-Control-Allow-Origin: https://system.avalonwoundcare.ph");

// Allow credentials if you are using sessions/cookies
header("Access-Control-Allow-Credentials: true");

// Allow the required methods
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

// Allow the required headers
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
?>
<?php
date_default_timezone_set("Asia/Manila");
class Database
{
    // local
    // private $host = "localhost";
    // private $db_name = "avalon";
    // private $username = "root";
    // private $password = '';


    //prod

    private $host = "216.218.206.42";
    private $db_name = "avalonwo_system";
    private $username = "avalonwo_admin";
    private $password = ']=?tcMar*xZ56Z^?';



    public $conn;

    public function dbConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}

?>