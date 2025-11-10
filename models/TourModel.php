<?php
class TourModel
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Viết truy vấn lấy dữ liệu cho trang chủ
    public function getHomeData()
    {
        // Ví dụ: Lấy danh sách sản phẩm nổi bật
        $sql = "SELECT * FROM products WHERE featured = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
