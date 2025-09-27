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

        $sortBy = isset($data['sortBy']) ? $data['sortBy'] : 'Fullname'; // default sort field
        $sort = isset($data['sort']) && in_array(strtoupper($data['sort']), ['ASC', 'DESC']) ? strtoupper($data['sort']) : 'ASC'; // default sort order
        if ($sortBy === 'PatientNo') {
            $sortBy = 'id';
        } elseif ($sortBy === 'Fullname') {
            $sortBy = "CONCAT(last_name, ', ', first_name, ' ', middle_name)";
        } elseif ($sortBy === 'Birthdate') {
            $sortBy = 'birth_date';
        } elseif ($sortBy === 'Age') {
            $sortBy = 'birth_date'; // Sorting by birth_date for age
            $sort = $sort === 'ASC' ? 'DESC' : 'ASC'; // Reverse order for age
        } else {
            $sortBy = "CONCAT(last_name, ', ', first_name, ' ', middle_name)";
        }

        $page = isset($data['page']) && is_numeric($data['page']) ? (int) $data['page'] : 1;
        $limit = 10; // records per page
        $offset = ($page - 1) * $limit;
        $search = isset($data['filter']) ? trim($data['filter']) : '';
        $searchFields = ['contact_number', 'email_address', 'account_type', 'emergency_contact_person', "CONCAT(last_name, ', ', first_name, ' ', middle_name)"];
        $dynamics = '';
        if (!empty($search)) {
            $orConditions = [];
            foreach ($searchFields as $field) {
                $orConditions[] = "$field LIKE :search";
            }
            $dynamics = 'WHERE (' . implode(' OR ', $orConditions) . ')';
        }

        $dynamics .= " ORDER BY $sortBy $sort ";

        try {
            // Count total patients for pagination
            $countQuery = "SELECT COUNT(*) as total FROM patients $dynamics ";
            $countStmt = $this->conn->prepare($countQuery);
            if (!empty($search)) {
                $countStmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
            }

            $countStmt->execute();
            $totalRecords = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
            $totalPages = ceil($totalRecords / $limit);

            // Fetch paginated records
            $query = "SELECT * FROM patients $dynamics  LIMIT :limit OFFSET :offset";
            $stmt = $this->conn->prepare($query);
            if (!empty($search)) {
                $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
            }
            $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
            $stmt->execute();

            $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'success' => true,
                'page' => $page,
                'per_page' => $limit,
                'total_records' => $totalRecords,
                'total_pages' => $totalPages,
                'data' => $patients,

            ];

        } catch (PDOException $e) {
            error_log("Database error in getPatients(): " . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Internal server error. Please try again later.' . $e->getMessage() . '----' . $countQuery . '-=---' . $query
            ];
        }

    }

}



?>