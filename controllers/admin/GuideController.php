<?php
require_once './models/admin/GuideModel.php';

class GuideController {
    private $model;

    public function __construct() {
        $this->model = new GuideModel();
    }

    // Trang danh sách hướng dẫn viên
    public function index() {
        $title = "Quản lý hướng dẫn viên";
        $guides = $this->model->getAll();
        $view = 'admin/guides/list';
        require_once 'layout/admin-main.php';
    }

    // Trang thêm mới
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'full_name' => $_POST['full_name'],
                'specialization' => $_POST['specialization'],
                'experience_years' => $_POST['experience_years'],
                'certificates' => $_POST['certificates'],
                'languages' => $_POST['languages'],
                'status' => $_POST['status']
            ];

            $this->model->insert($data);
            $_SESSION['success'] = "Thêm hướng dẫn viên thành công!";
            header("Location: ?act=admin_guides");
            exit;
        }

        $title = "Thêm hướng dẫn viên mới";
        $view = 'admin/guides/create';
        require_once 'layout/admin-main.php';
    }
}
?>
