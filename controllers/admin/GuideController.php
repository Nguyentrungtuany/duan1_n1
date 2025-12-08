<?php
require_once './models/admin/GuideModel.php';

class GuideController
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
        require_once 'views/admin/guides/guide-list.php';
    }

    // Trang thêm mới
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'full_name' => $_POST['full_name'],
                'specialization' => $_POST['specialization'],
                'experience_years' => $_POST['experience_years'],
                'certificates' => $_POST['certificates'],
                'languages' => $_POST['languages'],
                'status' => $_POST['status'],
                'user_id' => $_POST['user_id']
            ];

            $this->model->insert($data);
            $_SESSION['success'] = "Thêm hướng dẫn viên thành công!";
            header("Location: ?act=admin_guides");
            exit;
        }

        $availableUsers = $this->model->getAvailableUsers();
        $title = "Thêm hướng dẫn viên mới";
        require_once 'views/admin/guides/create.php';
    }

    public function edit($id)
    {
        $guide = $this->model->getById($id);
        $availableUsers = $this->model->getAvailableUsers();
        $title = "Chỉnh sửa hướng dẫn viên";
        require_once 'views/admin/guides/edit.php';
    }
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'full_name' => $_POST['full_name'],
                'specialization' => $_POST['specialization'],
                'experience_years' => $_POST['experience_years'],
                'certificates' => $_POST['certificates'],
                'languages' => $_POST['languages'],
                'status' => $_POST['status'],
                'user_id' => $_POST['user_id']
            ];

            $this->model->update($id, $data);
            $_SESSION['success'] = "Cập nhật hướng dẫn viên thành công!";
            header("Location: ?act=admin_guides");
            exit;
        }
    }

    // public function delete($id)
    // {
    //     $this->model->delete($id);
    //     $_SESSION['success'] = "Xóa hướng dẫn viên thành công!";
    //     header("Location: ?act=admin_guides");
    //     exit;
    // }
}
