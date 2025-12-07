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

            if (empty($data['amid']) || empty($data['instrumentList'])) {
                return [
                    'success' => false,
                    'message' => 'Missing required fields: pid or amid'
                ];
            }


            try {
                $this->conn->beginTransaction();
                $sql = "delete from ambulatory_instrument where amid=:amid";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(':amid', (int) $data['amid'], PDO::PARAM_INT);
                $stmt->execute();

                //insert iteration here

                $insertSql = "INSERT INTO ambulatory_instrument (amid, supid, ins_qty)
                          VALUES (:amid, :supid,  :qty)";
                $insertStmt = $this->conn->prepare($insertSql);

                foreach ($data['instrumentList'] as $instrument) {
                    $insertStmt->bindValue(':amid', (int) $data['amid'], PDO::PARAM_INT);
                    $insertStmt->bindValue(':supid', $instrument['supid'], PDO::PARAM_STR);

                    $insertStmt->bindValue(':qty', $instrument['qty'], PDO::PARAM_INT);
                    $insertStmt->execute();
                }


                $this->conn->commit();

                return [
                    "success" => true,
                    "message" => "Ambulatory instrument records updated successfully."
                ];
            } catch (Exception $e) {
                $this->conn->rollBack();
                return [
                    "success" => false,
                    "message" => "Transaction failed: " . $e->getMessage() . " : " . $sql
                ];
            }

        } catch (PDOException $e) {
            error_log("Database error in process(): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Internal server error: ' . $e->getMessage()
            ];
        }
    }



}



?>