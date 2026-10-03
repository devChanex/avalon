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
        $this->conn = $database->dbConnection();
    }

    public function process($data)
    {
        $amid = filter_var($data['amid'] ?? null, FILTER_VALIDATE_INT);
        if ($amid === false || $amid === null || $amid < 1) {
            return [
                'success' => false,
                'message' => 'A valid ambulatory surgery record ID is required.'
            ];
        }

        try {
            $stmt = $this->conn->prepare('DELETE FROM ambulatory_main WHERE amid = :amid');
            $stmt->bindValue(':amid', $amid, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                return [
                    'success' => false,
                    'message' => 'Ambulatory surgery record was not found.'
                ];
            }

            return [
                'success' => true,
                'message' => 'Ambulatory surgery record deleted successfully.'
            ];
        } catch (PDOException $e) {
            error_log('Database error in ambulatory-deleteService: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Unable to delete the ambulatory surgery record. Please try again.'
            ];
        }
    }
}
?>
