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
            $this->conn->beginTransaction();

            // Decode JSON data from frontend
            // $data = isset($_POST['data']) ? json_decode($_POST['data'], true) : [];

            if (empty($data['key']) || empty($data['id'])) {
                return [
                    'success' => false,
                    'message' => 'Missing required fields: pid or amid' . '--' . $data['id']
                ];
            }

            $table = $data['table'];

            $recordId = $data['id'];
            $key = $data['key'];

            // Fetch the saved record
            $query = "delete FROM {$table} WHERE {$key} = :id";
            $stmt2 = $this->conn->prepare($query);
            $stmt2->bindValue(':id', $recordId, PDO::PARAM_INT);
            $stmt2->execute();
            $record = $stmt2->fetch(PDO::FETCH_ASSOC);

            $this->conn->commit();
            return [
                "success" => true,
                "message" => "Record deleted successfully.",
                "record" => $record,

            ];

        } catch (Exception $e) {
            $this->conn->rollBack();
            return [
                "success" => false,
                "message" => "Transaction failed: " . $e->getMessage() . " : " . $recordId
            ];
        }


    }


}




?>