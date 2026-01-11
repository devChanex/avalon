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
            // Decode JSON data from frontend
            $data = isset($_POST['data']) ? json_decode($_POST['data'], true) : [];

            if (empty($data['billdate']) || empty($data['payment_type']) || empty($data['billingid'])) {
                return [
                    'success' => false,
                    'message' => 'Missing required fields: billdate or payment_type or billingid'
                ];
            }

            // If recordid is empty → INSERT

            try {
                $this->conn->beginTransaction();
                $sql = "update billing set
                        billdate = :billdate,
                        total_amount = :total_amount,
                        payment_type = :payment_type
                        where billingid = :billingid";

                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(':billdate', $data['billdate']);
                $stmt->bindValue(':total_amount', $data['total_amount']);
                $stmt->bindValue(':payment_type', $data['payment_type']);
                $stmt->bindValue(':billingid', $data['billingid']);
                $stmt->execute();

                //delete billing_sub
                $deleteSql = "DELETE FROM billing_sub WHERE bid = :billingid";
                $deleteStmt = $this->conn->prepare($deleteSql);
                $deleteStmt->bindValue(':billingid', $data['billingid']);
                $deleteStmt->execute();


                // decode charges JSON string
                $charges = json_decode($data['charges'], true);

                // insert billing_sub
                $insertSubSql = "
    INSERT INTO billing_sub (bid, item, amount)
    VALUES (:bid, :item, :amount)
";
                $insertSubStmt = $this->conn->prepare($insertSubSql);

                foreach ($charges as $charge) {
                    $insertSubStmt->bindValue(':bid', $data['billingid']);
                    $insertSubStmt->bindValue(':item', $charge['charge_item']);
                    $insertSubStmt->bindValue(':amount', $charge['amount']);
                    $insertSubStmt->execute();
                }


                $this->conn->commit();
                return [
                    "success" => true,
                    "message" => "Billing Updated Successfully."
                ];
            } catch (Exception $e) {
                $this->conn->rollBack();
                return [
                    "success" => false,
                    "message" => "Insert transaction failed: " . $e->getMessage()
                ];
            }




        } catch (PDOException $e) {
            error_log("Database error in process(): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Internal server error. ' . $e->getMessage()
            ];
        }
    }


}



?>