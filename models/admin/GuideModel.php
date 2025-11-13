<?php
require_once './commons/env.php';
require_once './commons/function.php';

class GuideModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB(); // Hàm có sẵn trong function.php
    }

    public function getAll() {
        $sql = "SELECT * FROM guides ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($data) {
        $sql = "INSERT INTO guides (full_name, specialization, experience_years, certificates, languages, status)
                VALUES (:full_name, :specialization, :experience_years, :certificates, :languages, :status)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':full_name' => $data['full_name'],
            ':specialization' => $data['specialization'],
            ':experience_years' => $data['experience_years'],
            ':certificates' => $data['certificates'],
            ':languages' => $data['languages'],
            ':status' => $data['status'],
        ]);
    }
}
