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
            $data = isset($_POST['data']) ? json_decode($_POST['data'], true) : [];
            $birthDate = !empty($data['birthDate'])
                ? DateTime::createFromFormat('m/d/Y', $data['birthDate'])->format('Y-m-d')
                : null;
            //check required fields
            if (empty($data['firstName']) || empty($data['lastName']) || empty($data['birthDate'])) {
                return [
                    'success' => false,
                    'message' => 'Missing required fields: first name, last name, or birthdate'
                ];
            }

            //check if patient record exist
            $checkQuery = "SELECT id FROM patients WHERE first_name = :first_name and last_name=:last_name and middle_name=:middle_name and birth_date=:birth_date LIMIT 1";
            $checkStmt = $this->conn->prepare($checkQuery);
            $checkStmt->bindValue(':first_name', $data['firstName']);
            $checkStmt->bindValue(':last_name', $data['lastName']);
            $checkStmt->bindValue(':middle_name', $data['middleName']);
            $checkStmt->bindValue(':birth_date', $birthDate);
            $checkStmt->execute();

            if ($checkStmt->fetch(PDO::FETCH_ASSOC)) {
                return [
                    'success' => false,
                    'message' => 'A patient with the same name and birthdate already exists'
                ];
            }

            $sql = "INSERT INTO patients 
            (first_name, middle_name, last_name, birth_date, birth_place, nationality, 
             gender, marital_status, religion, present_address, contact_number, email_address, 
             occupation, office_address, philhealth_number, account_type, please_specify, 
             emergency_contact_person, emergency_contact_number, relationship, is_agree)
            VALUES 
            (:firstName, :middleName, :lastName, :birthDate, :birthPlace, :nationality,
             :gender, :maritalStatus, :religion, :presentAddress, :contactNumber, :emailAddress,
             :occupation, :officeAddress, :philHealthNumber, :accountType, :pleaseSpecify,
             :emergencyContactPerson, :emergencyContactNumber, :relationship, :isAgree)";

            $stmt = $this->conn->prepare($sql);

            // bind params
            $stmt->bindValue(':firstName', $data['firstName']);
            $stmt->bindValue(':middleName', $data['middleName']);
            $stmt->bindValue(':lastName', $data['lastName']);
            $stmt->bindValue(':birthDate', $birthDate);
            $stmt->bindValue(':birthPlace', $data['birthPlace']);
            $stmt->bindValue(':nationality', $data['nationality']);
            $stmt->bindValue(':gender', $data['gender']);
            $stmt->bindValue(':maritalStatus', $data['maritalStatus']);
            $stmt->bindValue(':religion', $data['religion']);
            $stmt->bindValue(':presentAddress', $data['presentAddress']);
            $stmt->bindValue(':contactNumber', $data['contactNumber']);
            $stmt->bindValue(':emailAddress', $data['emailAddress']);
            $stmt->bindValue(':occupation', $data['occupation']);
            $stmt->bindValue(':officeAddress', $data['officeAddress']);
            $stmt->bindValue(':philHealthNumber', $data['philHealthNumber']);
            $stmt->bindValue(':accountType', $data['accountType']);
            $stmt->bindValue(':pleaseSpecify', $data['pleaseSpecify']);
            $stmt->bindValue(':emergencyContactPerson', $data['emergencyContactPerson']);
            $stmt->bindValue(':emergencyContactNumber', $data['emergencyContactNumber']);
            $stmt->bindValue(':relationship', $data['relationship']);
            $stmt->bindValue(':isAgree', $data['isAgree'] ? 1 : 0, PDO::PARAM_INT);

            $stmt->execute();

            return [
                'success' => true,
                'message' => 'Patient registered successfully'
            ];


        } catch (PDOException $e) {
            // Log the actual error for debugging (never expose raw DB errors to clients)
            error_log("Database error in process(): " . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Internal server error. Please try again later.'
            ];
        }
    }

}



?>