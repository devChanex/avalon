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

            if (empty($data['qty_received']) || empty($data['date_received'])) {
                return [
                    'success' => false,
                    'message' => 'Missing required fields'
                ];
            }


            $status = 'Updated';
            if (empty($data['invid'])) {
                try {
                    // Begin transaction
                    $this->conn->beginTransaction();

                    // Insert into inventory
                    $sql = "INSERT INTO inventory 
            (supid, date_expiry, date_received, qty_received, qty_onhand, qty_consumed, status) 
            VALUES (:supid, :date_expiry, :date_received, :qty_received, :qty_onhand, :qty_consumed, :status)";
                    $stmt = $this->conn->prepare($sql);

                    $stmt->bindValue(':supid', $data['supid']);
                    $stmt->bindValue(':date_expiry', $data['date_expiry']);
                    $stmt->bindValue(':date_received', $data['date_received']);
                    $stmt->bindValue(':qty_received', $data['qty_received']);
                    $stmt->bindValue(':qty_onhand', $data['qty_received']);
                    $stmt->bindValue(':qty_consumed', 0);
                    $stmt->bindValue(':status', 'Active');
                    $stmt->execute();

                    // Get last inserted ID
                    $lastId = $this->conn->lastInsertId();

                    // Insert into inventory_sub
                    $sql = "INSERT INTO inventory_sub (ref, qty, type, transaction_date) VALUES (:ref, :qty, :types, :transaction_date)";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindValue(':ref', $lastId);
                    $stmt->bindValue(':qty', $data['qty_received']);
                    $stmt->bindValue(':types', 'In');
                    $stmt->bindValue(':transaction_date', $data['date_received']);
                    $stmt->execute();

                    // ✅ Everything OK — commit transaction
                    $this->conn->commit();

                    return [
                        "success" => true,
                        "message" => "Inventory added successfully",
                        "last_id" => $lastId
                    ];

                } catch (Exception $e) {
                    // ❌ Something went wrong — rollback all queries
                    $this->conn->rollBack();

                    return [
                        "success" => false,
                        "message" => "Transaction failed: " . $e->getMessage()
                    ];
                }
            } else {
                // Update existing record
                try {
                    // Begin transaction
                    $this->conn->beginTransaction();
                    // update sub_inventory IN
                    $sql = "UPDATE inventory_sub SET qty=:qty WHERE ref=:invid and type='In'";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindValue(':invid', $data['invid']);
                    $stmt->bindValue(':qty', $data['qty_received']);
                    $stmt->execute();


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
                     SET qty_onhand = :qty_onhand , date_received=:date_received, date_expiry=:date_expiry, qty_received=:qty_received
                     WHERE invid = :invid";
                    $stmt = $this->conn->prepare($update);
                    $stmt->bindValue(':qty_onhand', $qty_onhand);
                    $stmt->bindValue(':invid', $data['invid']);
                    $stmt->bindValue(':date_received', $data['date_received']);
                    $stmt->bindValue(':date_expiry', $data['date_expiry']);
                    $stmt->bindValue(':qty_received', $data['qty_received']);
                    $stmt->execute();

                    $this->conn->commit();

                    return [
                        "success" => true,
                        "message" => "Inventory updated successfully"
                    ];
                } catch (Exception $e) {
                    // ❌ Something went wrong — rollback all queries
                    $this->conn->rollBack();

                    return [
                        "success" => false,
                        "message" => "Transaction failed: " . $e->getMessage()
                    ];
                }


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