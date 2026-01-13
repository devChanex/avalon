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

            if (empty($data['payments'])) {
                return [
                    'success' => false,
                    'message' => 'Missing required fields: payments'
                ];
            }

            // If recordid is empty → INSERT

            try {
                $this->conn->beginTransaction();

                //delete billing_sub
                $deleteSql = "DELETE FROM payment WHERE bid = :billingid";
                $deleteStmt = $this->conn->prepare($deleteSql);
                $deleteStmt->bindValue(':billingid', $data['billingid']);
                $deleteStmt->execute();


                // decode charges JSON string
                $payments = json_decode($data['payments'], true);

                // insert billing_sub
                $insertSubSql = "
    INSERT INTO payment (bid,pid, amount,mode,payment_date)
    VALUES (:bid, :pid, :amount, :mode, :payment_date)
";
                $insertSubStmt = $this->conn->prepare($insertSubSql);

                foreach ($payments as $payment) {
                    $insertSubStmt->bindValue(':bid', $data['billingid']);
                    $insertSubStmt->bindValue(':pid', $payment['pid']);
                    $insertSubStmt->bindValue(':mode', $payment['mode_of_payment']);
                    $insertSubStmt->bindValue(':amount', $payment['amount']);
                    $insertSubStmt->bindValue(':payment_date', $payment['payment_date']);
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