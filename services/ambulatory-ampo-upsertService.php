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
            // Decode JSON data from frontend
            $data = isset($_POST['data']) ? json_decode($_POST['data'], true) : [];

            if (empty($data['amid'])) {
                return [
                    'success' => false,
                    'message' => 'Missing required fields: pid or amid'
                ];
            }

            // Determine whether to insert or update
            $id_key = 'posdocid';
            $document_key = 'Physician Order Sheet';
            $isInsert = empty($data[$id_key]);
            $table = "physician_order_sheet_doc";

            // Filter only valid fields (non-null, existing keys)
            $fields = array_keys($data);

            // Prepare SQL dynamically
            if ($isInsert) {
                // Build INSERT statement
                $columns = implode(", ", $fields);
                $placeholders = ":" . implode(", :", $fields);
                $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
            } else {
                // Build UPDATE statement
                $updates = [];
                foreach ($fields as $field) {
                    if ($field !== 'amvid') {
                        $updates[] = "{$field} = :{$field}";
                    }
                }
                $sql = "UPDATE {$table} SET " . implode(", ", $updates) . " WHERE {$id_key} = :{$id_key}";
            }

            try {
                $this->conn->beginTransaction();
                $stmt = $this->conn->prepare($sql);

                // Bind values safely
                foreach ($fields as $f) {
                    if (is_array($data[$f])) {
                        $stmt->bindValue(':' . $f, json_encode($data[$f]));
                    } else {
                        $stmt->bindValue(':' . $f, $data[$f]);
                    }
                }

                $stmt->execute();

                // Get the record ID
                $recordId = $isInsert ? $this->conn->lastInsertId() : $data[$id_key];

                // Fetch the saved record
                $query = "SELECT * FROM {$table} WHERE {$id_key} = :id";
                $stmt2 = $this->conn->prepare($query);
                $stmt2->bindValue(':id', $recordId, PDO::PARAM_INT);
                $stmt2->execute();
                $record = $stmt2->fetch(PDO::FETCH_ASSOC);

                $this->conn->commit();

                return [
                    "success" => true,
                    "message" => $isInsert ? "{$document_key} added successfully." : "{$document_key} updated successfully.",
                    "record" => $record,

                ];
            } catch (Exception $e) {
                $this->conn->rollBack();
                return [
                    "success" => false,
                    "message" => "Transaction failed: " . $e->getMessage() . " : " . $sql
                ];
            }

        } catch (PDOException $e) {
            error_log("Database error in process(): " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Internal server error: ' . $e->getMessage()
            ];
        }
    }



}



?>