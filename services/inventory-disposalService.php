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

            if (empty($data['transaction_date']) || empty($data['qty_dispossal'])) {
                return [
                    'success' => false,
                    'message' => 'Missing required fields'
                ];
            }


            try {
                // Begin transaction
                $this->conn->beginTransaction();

                // Insert into inventory
                $sql = "INSERT INTO inventory_sub
            (ref, qty, type, transaction_date) 
            VALUES (:ref, :qty, :type, :transaction_date)";
                $stmt = $this->conn->prepare($sql);

                $stmt->bindValue(':ref', $data['invid']);
                $stmt->bindValue(':qty', $data['qty_dispossal']);
                $stmt->bindValue(':transaction_date', $data['transaction_date']);
                $stmt->bindValue(':type', 'Disposal');
                $stmt->execute();

                // ✅ Everything OK — commit transaction
                $this->conn->commit();

                return [
                    "success" => true,
                    "message" => "Item Disposed successfully",
                ];

            } catch (Exception $e) {
                // ❌ Something went wrong — rollback all queries
                $this->conn->rollBack();

                return [
                    "success" => false,
                    "message" => "Transaction failed: " . $e->getMessage()
                ];
            }












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