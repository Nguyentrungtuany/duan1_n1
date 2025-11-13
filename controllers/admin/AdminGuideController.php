<?php
require_once './models/Guide.php';

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
        $users = $user->All();
        
        // Truyền dữ liệu vào View
        require_once './views/admin/tables.php';
    }
}
?>