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
            $query = "SELECT a.*,CONCAT(last_name, ' ', suffix, ', ', first_name, ' ', middle_name) as fullname FROM ambulatory_consent a inner join patients b on a.pid=b.id  where amid=:ref LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':ref', (int) $data["ref"], PDO::PARAM_INT);
            $stmt->execute();

            $record = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($record)) {
                $query = "SELECT a.*,CONCAT(last_name, ' ', suffix, ', ', first_name, ' ', middle_name) as fullname,birth_date,contact_number,gender,present_address FROM ambulatory_main a inner join patients b on a.pid=b.id  where amid=:ref";
                $stmt = $this->conn->prepare($query);
                $stmt->bindValue(':ref', (int) $data["ref"], PDO::PARAM_INT);
                $stmt->execute();
                $record = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            // Fetch preop records
            $query = "SELECT * FROM preoperative_checklist where amid=:ref LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':ref', (int) $data["ref"], PDO::PARAM_INT);
            $stmt->execute();

            $preop = $stmt->fetchAll(PDO::FETCH_ASSOC);


            $query = "SELECT * FROM ambulatory_data where amid=:ref LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':ref', (int) $data["ref"], PDO::PARAM_INT);
            $stmt->execute();

            $ambulatory_data = $stmt->fetchAll(PDO::FETCH_ASSOC);


            return [
                'success' => true,
                'data' => $record,
                'preop' => $preop,
                'ambulatorydata' => $ambulatory_data

            ];

        } catch (PDOException $e) {
            error_log("Database error in getSupplies(): " . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Internal server error. Please try again later.' . $e->getMessage() . '-=---' . $query
            ];
        }

    }

}



?>