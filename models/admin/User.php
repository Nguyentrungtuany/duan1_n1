<?php
class User {
    private $conn;
    
    public function __construct() {
        $this->conn = connectDB();
    }
    
    public function All() {
        try {
           
            $sql = "SELECT * FROM users ORDER BY id DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
            return [];
        }
    }
}
?>