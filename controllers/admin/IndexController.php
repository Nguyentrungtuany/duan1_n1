<?php
class IndexController
{
    public function index()
    {
        require_once './views/admin/IndexAdmin.php';
    }
    
    public function tables()
    {
        // Lấy dữ liệu từ Model
        $user = new User();
        $guides = $user->All(); // Đổi biến $users thành $guides
        
        // Truyền dữ liệu vào View
        require_once './views/admin/tables.php';
    }
}
?>