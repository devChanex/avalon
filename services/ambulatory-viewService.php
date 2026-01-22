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

            $query = "SELECT * FROM ambulatory_vital where amid=:ref";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':ref', (int) $data["ref"], PDO::PARAM_INT);
            $stmt->execute();

            $ambulatory_vital = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $query = "SELECT * FROM ambulatory_progress_order where amid=:ref";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':ref', (int) $data["ref"], PDO::PARAM_INT);
            $stmt->execute();

            $ambulatory_ampo = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // $query = "SELECT * FROM ambulatory_progress_nurse where amid=:ref";
            // $stmt = $this->conn->prepare($query);
            // $stmt->bindValue(':ref', (int) $data["ref"], PDO::PARAM_INT);
            // $stmt->execute();
            // $ambulatory_ampn = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $query = "SELECT amnpnid,notes FROM ambulatory_nurse_progress_note where amid=:ref";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':ref', (int) $data["ref"], PDO::PARAM_INT);
            $stmt->execute();

            $ambulatory_ampn = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $query = "SELECT * FROM ambulatory_technique where amid=:ref";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':ref', (int) $data["ref"], PDO::PARAM_INT);
            $stmt->execute();

            $ambulatory_technique = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $query = "SELECT * FROM ambulatory_medication_sheet where amid=:ref";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':ref', (int) $data["ref"], PDO::PARAM_INT);
            $stmt->execute();

            $ambulatory_medication_sheet = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $query = "SELECT * FROM ambulatory_medication_sheet_nurse where amid=:ref";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':ref', (int) $data["ref"], PDO::PARAM_INT);
            $stmt->execute();

            $ambulatory_medication_sheet_nurse = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Instrument Count Sheet
            $query = "SELECT s.supid,s.classification,s.itemname,COALESCE(ai.ins_qty,0) AS qty FROM supplies s LEFT JOIN ambulatory_instrument ai ON s.supid=ai.supid AND ai.amid = :ref";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':ref', (int) $data["ref"], PDO::PARAM_INT);
            $stmt->execute();
            $ambulatory_instrument_count = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $query = "SELECT * FROM ambulatory_instrument_counts where amid=:ref";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':ref', (int) $data["ref"], PDO::PARAM_INT);
            $stmt->execute();

            $ambulatory_ics = $stmt->fetchAll(PDO::FETCH_ASSOC);


            return [
                'success' => true,
                'data' => $record,
                'preop' => $preop,
                'ambulatorydata' => $ambulatory_data,
                'ambulatoryvital' => $ambulatory_vital,
                'ambulatoryampo' => $ambulatory_ampo,
                'ambulatoryampn' => $ambulatory_ampn,
                'ambulatorytechnique' => $ambulatory_technique,
                'ambulatorymedicationsheet' => $ambulatory_medication_sheet,
                'ambulatorymedicationsheetnurse' => $ambulatory_medication_sheet_nurse,
                'ambulatoryinstrumentcount' => $ambulatory_instrument_count,
                'ambulatoryics' => $ambulatory_ics

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