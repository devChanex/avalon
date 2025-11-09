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
            //Variables
            $patientCount = 0;
            $outpatientCount = 0;
            $ambulatorypatientCount = 0;
            //PatientProfiles
            $query = "select count(*) as dataCount from patients";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $record = $stmt->fetch(PDO::FETCH_ASSOC); // fetch single row
            $patientCount = $record['dataCount'] ?? 0;

            //outpatient
            $query = "select count(*) as dataCount from opd_consultation where year(consultation_date) = year(curdate())";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $record = $stmt->fetch(PDO::FETCH_ASSOC); // fetch single row
            $outpatientCount = $record['dataCount'] ?? 0;

            //ambulatory patient
            $query = "select count(*) as dataCount from ambulatory_main where year(surgery_date) = year(curdate())";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $record = $stmt->fetch(PDO::FETCH_ASSOC); // fetch single row
            $ambulatorypatientCount = $record['dataCount'] ?? 0;

            //MONTHLY REPORT PANEL
            $query = "
SELECT 
    m.month,
    COALESCE(a.ambulatory_count, 0) AS ambulatory_count,
    COALESCE(o.opd_count, 0) AS opd_count
FROM (
    SELECT DATE_FORMAT(surgery_date, '%Y-%m') AS month
    FROM ambulatory_main
    WHERE YEAR(surgery_date) = YEAR(CURDATE())

    UNION

    SELECT DATE_FORMAT(consultation_date, '%Y-%m') AS month
    FROM opd_consultation
    WHERE YEAR(consultation_date) = YEAR(CURDATE())
) m
LEFT JOIN (
    SELECT DATE_FORMAT(surgery_date, '%Y-%m') AS month, COUNT(DISTINCT amid) AS ambulatory_count
    FROM ambulatory_main
    WHERE YEAR(surgery_date) = YEAR(CURDATE())
    GROUP BY month
) a ON m.month = a.month
LEFT JOIN (
    SELECT DATE_FORMAT(consultation_date, '%Y-%m') AS month, COUNT(DISTINCT opdcid) AS opd_count
    FROM opd_consultation
    WHERE YEAR(consultation_date) = YEAR(CURDATE())
    GROUP BY month
) o ON m.month = o.month
ORDER BY m.month ASC;
";


            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $monthlyData = $records;


            return [
                'success' => true,
                'patientcount' => $patientCount,
                'outpatientcount' => $outpatientCount,
                'ambulatorypatientcount' => $ambulatorypatientCount,
                'monthlydata' => $monthlyData


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