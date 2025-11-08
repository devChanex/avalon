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
            if (empty($data['consentid'])) {

                $fields = [
                    'pid',
                    'amid',
                    'procedures',
                    'surgery_date',
                    'exception',
                    'nurse_in_charge',

                    'physician'
                ];
                try {
                    $this->conn->beginTransaction();
                    $sql = "INSERT INTO ambulatory_consent (
                    procedure_datetime,
                    pid,
                    amid,
                    
                    procedures,
                    exception,
                    nurse_in_charge,
                    physician
                ) VALUES (
                    :surgery_date,
                    :pid,
                    :amid,
                    :procedures,
                    :exception,
                    :nurse_in_charge,
                    :physician
                )";

                    $stmt = $this->conn->prepare($sql);
                    foreach ($fields as $f) {
                        $sql = $sql . $f . ",";
                        $stmt->bindValue(':' . $f, $data[$f] ?? null);
                    }
                    $stmt->execute();

                    $lastId = $this->conn->lastInsertId();
                    // Fetch the newly inserted record
                    $query = "SELECT * FROM ambulatory_consent WHERE acid = :id"; // 👈 change table name & primary key as needed
                    $stmt2 = $this->conn->prepare($query);
                    $stmt2->bindValue(':id', $lastId, PDO::PARAM_INT);
                    $stmt2->execute();
                    $record = $stmt2->fetch(PDO::FETCH_ASSOC);

                    $this->conn->commit();
                    $record['fullname'] = $data['fullname'] ?? '';
                    return [
                        "success" => true,
                        "message" => "Consent recorded successfully.",
                        "data" => $record
                    ];
                } catch (Exception $e) {
                    $this->conn->rollBack();
                    return [
                        "success" => false,
                        "message" => "Insert transaction failed: " . $e->getMessage() . " : " . $sql
                    ];
                }

            } else {

                $fields = [
                    'pid',
                    'amid',
                    'consentid',
                    'procedures',
                    'surgery_date',
                    'exception',
                    'nurse_in_charge',
                    'physician'
                ];
                try {
                    $this->conn->beginTransaction();
                    $sql = "UPDATE ambulatory_consent set
                    procedure_datetime=:surgery_date,
                    pid=:pid,
                    amid=:amid,
                    procedures=:procedures,
                    exception=:exception,
                    nurse_in_charge=:nurse_in_charge,
                    physician=:physician
                WHERE acid=:consentid";


                    $stmt = $this->conn->prepare($sql);
                    foreach ($fields as $f) {
                        $sql = $sql . $f . ",";
                        $stmt->bindValue(':' . $f, $data[$f] ?? null);
                    }
                    $stmt->execute();

                    // Fetch the newly inserted record
                    $query = "SELECT * FROM ambulatory_consent WHERE acid = :id"; // 👈 change table name & primary key as needed
                    $stmt2 = $this->conn->prepare($query);
                    $stmt2->bindValue(':id', $data["consentid"], PDO::PARAM_INT);
                    $stmt2->execute();
                    $record = $stmt2->fetch(PDO::FETCH_ASSOC);

                    $this->conn->commit();
                    $record['fullname'] = $data['fullname'] ?? '';
                    return [
                        "success" => true,
                        "message" => "Consent updated successfully.",
                        "data" => $data,
                        "record" => $record
                    ];
                } catch (Exception $e) {
                    $this->conn->rollBack();
                    return [
                        "success" => false,
                        "message" => "Insert transaction failed: " . $e->getMessage() . " : " . $sql
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