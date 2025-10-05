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

            if (empty($data['invid'])) {
                return [
                    'success' => false,
                    'message' => 'Missing required fields'
                ];
            }

            // Update existing record
            try {
                // Begin transaction
                $this->conn->beginTransaction();


                // recompute stocks
                $sql = "SELECT type, SUM(qty) AS total_qty  FROM inventory_sub WHERE ref = :invid GROUP BY type";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(':invid', $data['invid']);
                $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $result = [
                    'In' => 0,
                    'Out' => 0,
                    'Disposal' => 0
                ];

                foreach ($rows as $row) {
                    $result[$row['type']] = $row['total_qty'];
                }

                $qty_onhand = $result['In'] - $result['Out'] - $result['Disposal'];

                $update = "UPDATE inventory 
                     SET qty_onhand = :qty_onhand
                     WHERE invid = :invid";
                $stmt = $this->conn->prepare($update);
                $stmt->bindValue(':qty_onhand', $qty_onhand);
                $stmt->bindValue(':invid', $data['invid']);
                $stmt->execute();

                $this->conn->commit();

                return [
                    "success" => true,
                    "message" => "Inventory updated successfully",
                    "results" => $result
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