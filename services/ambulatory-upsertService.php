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

            if (empty($data['surgery_date']) || empty($data['pid'])) {
                return [
                    'success' => false,
                    'message' => 'Missing required fields: consultation_date or pid'
                ];
            }

            // If recordid is empty → INSERT
            if (empty($data['amid'])) {

                $fields = [
                    'surgery_date',
                    'pid',
                    'procedures',
                    'physician'
                ];
                try {
                    $this->conn->beginTransaction();

                    $sql = "INSERT INTO ambulatory_main (
                    surgery_date,
                    pid,
                    procedures,
                    physician
                ) VALUES (
                    :surgery_date,
                    :pid,
                    :procedures,
                    :physician
                )";

                    $stmt = $this->conn->prepare($sql);
                    foreach ($fields as $f) {
                        $stmt->bindValue(':' . $f, $data[$f] ?? null);
                    }
                    $stmt->execute();
                    $lastId = $this->conn->lastInsertId();

                    //INSERT BILLING
                    $sql2 = "INSERT INTO billing (
                        reference_number,
                        transaction_type,
                        pid,
                        physician
                        ) VALUES (
                        :reference_number,
                        :transaction_type,
                        :pid,
                        :physician
                     )";
                    $stmt2 = $this->conn->prepare($sql2);
                    $stmt2->bindValue(':reference_number', $lastId);
                    $stmt2->bindValue(':transaction_type', 'AMBULATORY');
                    $stmt2->bindValue(':pid', $data['pid']);
                    $stmt2->bindValue(':physician', $data['physician'] ?? null);
                    $stmt2->execute();
                    $this->conn->commit();


                    return [
                        "success" => true,
                        "message" => "Consultation record added successfully.",
                        "last_id" => $lastId
                    ];
                } catch (Exception $e) {
                    $this->conn->rollBack();
                    return [
                        "success" => false,
                        "message" => "Insert transaction failed: " . $e->getMessage()
                    ];
                }

            } else {

                $fields = [
                    'amid',
                    'surgery_date',
                    'pid',
                    'procedures',
                    'physician'
                ];
                // If recordid exists → UPDATE
                try {
                    $this->conn->beginTransaction();

                    $sql = "UPDATE ambulatory_main SET
                   
                    surgery_date = :surgery_date,
                  
                    pid = :pid,
                    procedures = :procedures,
                    physician = :physician
                WHERE amid = :amid";

                    $stmt = $this->conn->prepare($sql);
                    foreach ($fields as $f) {
                        $stmt->bindValue(':' . $f, $data[$f] ?? null);
                    }

                    $stmt->execute();
                    $this->conn->commit();

                    return [
                        "success" => true,
                        "message" => "Consultation record updated successfully."
                    ];
                } catch (Exception $e) {
                    $this->conn->rollBack();
                    return [
                        "success" => false,
                        "message" => "Update transaction failed: " . $e->getMessage() . " : " . $sql
                    ];
                }
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