<?php
header('Access-Control-Allow-Origin: *');
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