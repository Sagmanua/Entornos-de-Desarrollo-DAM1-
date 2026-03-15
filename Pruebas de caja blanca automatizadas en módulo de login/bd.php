<?php
// bd.php
class Database {
    private $conn;

    public function __construct() {
        // En un entorno real, aquí irían tus credenciales
        $this->conn = new mysqli("localhost", "root", "", "tu_base_de_datos");
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>