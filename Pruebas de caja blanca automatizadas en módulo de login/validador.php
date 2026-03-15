<?php
// validador.php
class LoginValidator {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function validateLogin($username, $password) {
        $stmt = $this->conn->prepare("SELECT id, password FROM users WHERE username = ?");
        if (!$stmt) return 'db_error';

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                return 'success';
            }
            return 'invalid_password';
        }
        return 'user_not_found';
    }
}