<?php

header("Access-Control-Allow-Origin: https://system.avalonwoundcare.ph");
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
        if (empty($data['username']) || empty($data['password'])) {
            return [
                'success' => false,
                'message' => 'Missing username or password'
            ];
        }

        $username = trim($data['username']);
        $password = $data['password'];

        try {
            $query = "SELECT * FROM users WHERE username = :username LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // if ($user && password_verify($password, $user['password'])) {
            if ($user && $password === $user['password']) {
                session_start();
                $_SESSION['username'] = $user["username"];
                $_SESSION['email'] = $user["email"];
                $_SESSION['lastUpdate'] = $user["lastUpdate"];
                $_SESSION['account_type'] = $user["account_type"];

                return [
                    'success' => true,
                    'message' => 'Login successful',
                    'data' => [
                        'email' => $user["email"],
                        'account_type' => $user["account_type"]
                    ]
                ];
            }

            return [
                'success' => false,
                'message' => 'Invalid username or password'
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