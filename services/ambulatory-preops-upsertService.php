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

            if (empty($data['amid'])) {
                return [
                    'success' => false,
                    'message' => 'Missing required fields'
                ];
            }

            // If recordid is empty → INSERT
            if (empty($data['preopcheckid'])) {

                $fields = [

                    'amid',
                    'BP',
                    'RR',
                    'OSat',
                    'HR',
                    'TEMP',
                    'LMP',
                    'HT',
                    'WT',
                    'allergies',
                    'last_meal',
                    'lab_result',
                    'last_dose',
                    'diagnosis'
                ];

                try {
                    $this->conn->beginTransaction();
                    $sql = "INSERT INTO preoperative_checklist (
            amid,
            BP,
            RR,
            OSat,
            HR,
            TEMP,
            LMP,
            HT,
            WT,
            allergies,
            last_meal,
            lab_result,
            last_dose,
            diagnosis
        ) VALUES (
            :amid,
            :BP,
            :RR,
            :OSat,
            :HR,
            :TEMP,
            :LMP,
            :HT,
            :WT,
            :allergies,
            :last_meal,
            :lab_result,
            :last_dose,
            :diagnosis
        )";


                    $stmt = $this->conn->prepare($sql);
                    foreach ($fields as $f) {
                        $sql = $sql . $f . ",";
                        $stmt->bindValue(':' . $f, $data[$f] ?? null);
                    }
                    $stmt->execute();

                    $lastId = $this->conn->lastInsertId();
                    // Fetch the newly inserted record
                    $query = "SELECT * FROM preoperative_checklist WHERE preopcheckid = :id"; // 👈 change table name & primary key as needed
                    $stmt2 = $this->conn->prepare($query);
                    $stmt2->bindValue(':id', $lastId, PDO::PARAM_INT);
                    $stmt2->execute();
                    $record = $stmt2->fetch(PDO::FETCH_ASSOC);

                    $this->conn->commit();

                    return [
                        "success" => true,
                        "message" => "Preoperative Checklist recorded successfully.",
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
                    'preopcheckid',
                    'amid',
                    'BP',
                    'RR',
                    'OSat',
                    'HR',
                    'TEMP',
                    'LMP',
                    'HT',
                    'WT',
                    'allergies',
                    'last_meal',
                    'lab_result',
                    'last_dose',
                    'diagnosis'
                ];

                try {
                    $this->conn->beginTransaction();
                    $sql = "UPDATE preoperative_checklist SET
            amid = :amid,
            BP = :BP,
            RR = :RR,
            OSat = :OSat,
            HR = :HR,
            TEMP = :TEMP,
            LMP = :LMP,
            HT = :HT,
            WT = :WT,
            allergies = :allergies,
            last_meal = :last_meal,
            lab_result = :lab_result,
            last_dose = :last_dose,
            diagnosis=:diagnosis
        WHERE preopcheckid = :preopcheckid";



                    $stmt = $this->conn->prepare($sql);
                    foreach ($fields as $f) {
                        $sql = $sql . $f . ",";
                        $stmt->bindValue(':' . $f, $data[$f] ?? null);
                    }
                    $stmt->execute();

                    // Fetch the newly inserted record
                    $query = "SELECT * FROM preoperative_checklist WHERE preopcheckid = :id"; // 👈 change table name & primary key as needed
                    $stmt2 = $this->conn->prepare($query);
                    $stmt2->bindValue(':id', $data["preopcheckid"], PDO::PARAM_INT);
                    $stmt2->execute();
                    $record = $stmt2->fetch(PDO::FETCH_ASSOC);

                    $this->conn->commit();
                    $record['fullname'] = $data['fullname'] ?? '';
                    return [
                        "success" => true,
                        "message" => "Preoperative Checklist updated successfully.",
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