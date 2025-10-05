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

        $sortBy = isset($data['sortBy']) ? $data['sortBy'] : 'invid'; // default sort field
        $sort = isset($data['sort']) && in_array(strtoupper($data['sort']), ['ASC', 'DESC']) ? strtoupper($data['sort']) : 'ASC'; // default sort order

        $page = isset($data['page']) && is_numeric($data['page']) ? (int) $data['page'] : 1;
        $limit = 10; // records per page
        $offset = ($page - 1) * $limit;
        $search = isset($data['filter']) ? trim($data['filter']) : '';
        $searchFields = ["CONCAT('INV', LPAD(a.invid, 6, '0'))", 'b.itemname', 'date_received', 'date_expiry', 'remarks', "CONCAT('S', LPAD(a.supid, 6, '0'))"];
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
            $countQuery = "SELECT COUNT(itemname) as total FROM inventory a inner join supplies b on a.supid=b.supid $dynamics ";
            $countStmt = $this->conn->prepare($countQuery);
            if (!empty($search)) {
                $countStmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
            }

            $countStmt->execute();
            $totalRecords = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
            $totalPages = ceil($totalRecords / $limit);




            // Fetch paginated records
            $query = "SELECT a.*,b.itemname FROM inventory a inner join supplies b on a.supid=b.supid $dynamics  LIMIT :limit OFFSET :offset";
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
            error_log("Database error in getSupplies(): " . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Internal server error. Please try again later.' . $e->getMessage() . '----' . $countQuery . '-=---' . $query
            ];
        }

    }

}



?>