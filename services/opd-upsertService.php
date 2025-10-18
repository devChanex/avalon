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

            if (empty($data['consultation_date']) || empty($data['pid'])) {
                return [
                    'success' => false,
                    'message' => 'Missing required fields: consultation_date or pid'
                ];
            }

            // If recordid is empty → INSERT
            if (empty($data['recordid'])) {

                $fields = [

                    'consultation_date',
                    'lmp',
                    'pid',
                    'service',
                    'physician',
                    'chief_complaint',
                    'bp',
                    'rr',
                    'hr',
                    'weight',
                    'height',
                    'temp',
                    'saturation',
                    'allergies',
                    'past',
                    'note'
                ];
                try {
                    $this->conn->beginTransaction();

                    $sql = "INSERT INTO opd_consultation (
         
                    consultation_date,
                
                    pid,
                    service,
                    physician,
                    chief_complaint,
                    bp,
                    rr,
                    hr,
                    weight,
                    height,
                    temp,
                    saturation,
                    allergies,
                    past,
                    note,
                    lmp
                ) VALUES (
            
                    :consultation_date,
                  
                    :pid,
                    :service,
                    :physician,
                    :chief_complaint,
                    :bp,
                    :rr,
                    :hr,
                    :weight,
                    :height,
                    :temp,
                    :saturation,
                    :allergies,
                    :past,
                    :note,
                    :lmp
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
                    'consultation_date',
                    'lmp',
                    'pid',
                    'service',
                    'physician',
                    'chief_complaint',
                    'bp',
                    'rr',
                    'hr',
                    'weight',
                    'height',
                    'temp',
                    'saturation',
                    'allergies',
                    'past',
                    'note'
                ];
                // If recordid exists → UPDATE
                try {
                    $this->conn->beginTransaction();

                    $sql = "UPDATE opd_consultation SET
                   
                    consultation_date = :consultation_date,
                  
                    pid = :pid,
                    service = :service,
                    physician = :physician,
                    chief_complaint = :chief_complaint,
                    bp = :bp,
                    rr = :rr,
                    hr = :hr,
                    weight = :weight,
                    height = :height,
                    temp = :temp,
                    saturation = :saturation,
                    allergies = :allergies,
                    past = :past,
                    note = :note,
                    lmp = :lmp
                WHERE opdcid = :recordid";

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