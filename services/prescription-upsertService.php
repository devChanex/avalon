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

            if (empty($data['prescription']) || empty($data['pid'])) {
                return [
                    'success' => false,
                    'message' => 'Missing required fields: consultation_date or pid'
                ];
            }

            // If recordid is empty → INSERT
            if (empty($data['recordid'])) {

                $fields = [

                    'pid',
                    'prescription',
                    'physician',
                    'prescription_date',
                    'next_appointment'

                ];
                try {
                    $this->conn->beginTransaction();

                    $sql = "INSERT INTO prescription (
         
                    pid,
                    prescription,
                    physician,
                    prescription_date,
                    next_appointment
                ) VALUES (
            
                    :pid,
                    :prescription,
                    :physician,
                    :prescription_date,
                    :next_appointment
                )";

                    $stmt = $this->conn->prepare($sql);
                    foreach ($fields as $f) {
                        $stmt->bindValue(':' . $f, $data[$f] ?? null);
                    }
                    $stmt->execute();
                    $lastId = $this->conn->lastInsertId();

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
                    'recordid',
                    'pid',
                    'prescription',
                    'physician',
                    'prescription_date',
                    'next_appointment'
                ];
                // If recordid exists → UPDATE
                try {
                    $this->conn->beginTransaction();

                    $sql = "UPDATE prescription SET
                    pid = :pid,
                    physician = :physician,
                    prescription = :prescription,
                    prescription_date = :prescription_date,
                    next_appointment = :next_appointment

                WHERE prescriptid = :recordid";

                    $stmt = $this->conn->prepare($sql);
                    foreach ($fields as $f) {
                        $stmt->bindValue(':' . $f, $data[$f] ?? null);
                    }

                    $stmt->execute();
                    $this->conn->commit();

                    return [
                        "success" => true,
                        "message" => "Prescription record updated successfully."
                    ];
                } catch (Exception $e) {
                    $this->conn->rollBack();
                    return [
                        "success" => false,
                        "message" => "Update transaction failed: " . $e->getMessage()
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