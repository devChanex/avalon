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


        try {
            $data = isset($_POST['data']) ? json_decode($_POST['data'], true) : [];

            if (empty($data['itemname']) || empty($data['price_cash']) || empty($data['status'])) {
                return [
                    'success' => false,
                    'message' => 'Missing required fields'
                ];
            }

            //check if patient record exist
            $checkQuery = "SELECT supid FROM supplies WHERE itemname = :itemname and description=:description and type=:type and  isConsumable=:isConsumable  and supid<> :id LIMIT 1";
            $checkStmt = $this->conn->prepare($checkQuery);
            $checkStmt->bindValue(':itemname', $data['itemname']);
            $checkStmt->bindValue(':description', $data['description']);
            $checkStmt->bindValue(':id', $data['supid']);
            $checkStmt->bindValue(':type', $data['type']);
            $checkStmt->bindValue(':isConsumable', $data['isConsumable']);

            $checkStmt->execute();

            if ($checkStmt->fetch(PDO::FETCH_ASSOC)) {
                return [
                    'success' => false,
                    'message' => 'Record already exists'
                ];
            }

            $status = 'Updated';
            if (empty($data['supid'])) {
                // Insert new record
                $sql = "INSERT INTO supplies (itemname, description, price_cash,price_hmo,price_discounted, type,classification, status, isConsumable,rsv) VALUES (:itemname, :description, :price_cash,:price_hmo,:price_discounted, :type,:classification, :status, :isConsumable, :rsv)";
                $stmt = $this->conn->prepare($sql);
                $status = "Added";
            } else {
                // Update existing record
                $sql = "UPDATE supplies SET itemname=:itemname, description=:description,  price_cash=:price_cash,price_hmo=:price_hmo,price_discounted=:price_discounted, type=:type,classification=:classification isConsumable=:isConsumable ,status=:status, rsv=:rsv WHERE supid=:supid";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(':supid', $data['supid']);
            }





            // bind params
            $stmt->bindValue(':itemname', $data['itemname']);
            $stmt->bindValue(':isConsumable', $data['isConsumable']);
            $stmt->bindValue(':type', $data['type']);
            $stmt->bindValue(':classification', $data['classification']);
            $stmt->bindValue(':description', $data['description']);
            $stmt->bindValue(':price_cash', $data['price_cash']);
            $stmt->bindValue(':price_hmo', $data['price_hmo']);
            $stmt->bindValue(':price_discounted', $data['price_discounted']);
            $stmt->bindValue(':status', $data['status']);
            $stmt->bindValue(':rsv', $data['rsv']);


            $stmt->execute();

            return [
                'success' => true,
                'message' => 'Record Successfully ' . $status
            ];


        } catch (PDOException $e) {
            // Log the actual error for debugging (never expose raw DB errors to clients)
            error_log("Database error in process(): " . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Internal server error. Please try again later. Message' . $e->getMessage()
            ];
        }
    }

}



?>