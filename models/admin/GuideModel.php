<?php
class GuideModel {
    private $conn;
    
    public function __construct() {
        $this->conn = connectDB();
    }
    
    public function getAllGuides() {
       $sql = "SELECT * FROM users ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}