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
                    'current_medication',
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
                    current_medication,
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
                    :current_medication,
                    :note,
                    :lmp
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
                    $stmt2->bindValue(':transaction_type', 'OPD');
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
                    'current_medication',
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
                    current_medication = :current_medication,
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