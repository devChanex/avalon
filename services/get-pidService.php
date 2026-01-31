<?php
require_once('databaseService.php');
$service = new ServiceClass();
$result = $service->process($_POST);
header('Content-Type: application/json');

exit(json_encode($result));


class ServiceClass
{

    private $conn;
    public function __construct()
    {
        $database = new Database();
        $db = $database->dbConnection();
        $this->conn = $db;
    }

    public function runQuery($sql)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }
    public function process($data)
    {
        $data = isset($_POST['data']) ? json_decode($_POST['data'], true) : [];

        try {
            // Fetch single record
            $query = "SELECT id FROM patients WHERE patient_no = :patientno";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':patientno', $data['filter']);
            $stmt->execute();

            $pid = $stmt->fetch(PDO::FETCH_ASSOC); // fetch only one record

            return [
                'success' => true,
                'data' => $pid, // single record as associative array
            ];

        } catch (PDOException $e) {
            error_log("Database error in getSupplies(): " . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Internal server error. Please try again later. ' . $e->getMessage()
            ];
        }

    }

}



?>