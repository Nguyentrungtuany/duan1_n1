<?php
require_once './commons/function.php';
class IndexModel
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }
    public function QlTour()
    {
        $sql = "SELECT * FROM tours";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }
    public function findTour($id)
    {
        $sql = "SELECT * FROM `tours` WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function updateqltour($id, $data)
    {
        $sql = "UPDATE `tours` SET `name`= :name ,
        `category`= :category,`description`= :description,
        `start_date`= :start_date,`end_date`= :end_date,
        `price`= :price,`status`= :status WHERE `id` = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':category', $data['category']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':start_date', $data['start_date']);
        $stmt->bindParam(':end_date', $data['end_date']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function deleteQltour($id)
    {
        $sql = "DELETE FROM `tours` WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
