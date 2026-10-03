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
        $opdcid = filter_var($data['opdcid'] ?? null, FILTER_VALIDATE_INT);
        if ($opdcid === false || $opdcid === null || $opdcid < 1) {
            return [
                'success' => false,
                'message' => 'A valid OPD consultation record ID is required.'
            ];
        }

        try {
            $stmt = $this->conn->prepare('DELETE FROM opd_consultation WHERE opdcid = :opdcid');
            $stmt->bindValue(':opdcid', $opdcid, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                return [
                    'success' => false,
                    'message' => 'OPD consultation record was not found.'
                ];
            }

            return [
                'success' => true,
                'message' => 'OPD consultation record deleted successfully.'
            ];
        } catch (PDOException $e) {
            error_log('Database error in opd-consultation-deleteService: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Unable to delete the OPD consultation record. Please try again.'
            ];
        }
    }
}
?>
