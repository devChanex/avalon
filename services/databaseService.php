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