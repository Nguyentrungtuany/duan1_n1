<?php 
class Guide {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }
    
    public function All() {
        $stmt = $this->conn->prepare("SELECT * FROM users ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM guides WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM guides WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
?>