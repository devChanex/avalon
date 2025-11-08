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
            $query = "select *,CONCAT(last_name, ' ', suffix, ', ', first_name, ' ', middle_name) as fullname from patients where id=:ref";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':ref', (int) $data["ref"], PDO::PARAM_INT);
            $stmt->execute();
            $record = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return [
                'success' => true,
                'data' => $record,

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