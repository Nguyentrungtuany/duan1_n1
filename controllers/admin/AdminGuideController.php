<?php
require_once './models/admin/GuideModel.php';

class AdminGuideController
{
    private $model;

    public function __construct()
    {
        $this->model = new GuideModel();
    }

    // Trang danh sách hướng dẫn viên
    public function index()
    {
        $title = "Quản lý hướng dẫn viên";
        $guides = $this->model->getAll();
        $view = './views/admin/guides/list.php';
        require_once './views/admin/IndexAdmin.php';
    }

    // Trang thêm mới
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'full_name' => $_POST['full_name'] ?? '',
                'specialization' => $_POST['specialization'] ?? '',
                'experience_years' => $_POST['experience_years'] ?? 0,
                'certificates' => $_POST['certificates'] ?? '',
                'languages' => $_POST['languages'] ?? '',
                'status' => $_POST['status'] ?? 'active'
            ];
            $this->model->insert($data);
            $_SESSION['success'] = "Thêm hướng dẫn viên thành công!";
            header("Location: ?act=admin_guides");
            exit;
        } else {
            $title = "Thêm hướng dẫn viên";
            $view = './views/admin/guides/create.php';
            require_once './views/admin/IndexAdmin.php';
        }
    }
}
