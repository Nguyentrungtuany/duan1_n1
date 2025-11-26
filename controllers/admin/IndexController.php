<?php

require_once './models/admin/IndexModel.php';
class IndexController
{
    public $indexModel;
    public function __construct()
    {
        $this->indexModel = new IndexModel();
    }
    public function index()
    {

        require_once './views/admin/IndexAdmin.php';
    }
    public function QlTuor()
    {
        $DataQltour = $this->indexModel->QlTour();
        require_once './views/admin/QlTour.php';
    }
    public function editQltour($id)
    {
        // $DataQltour = $this->indexModel->QlTour();
        $id = $_GET['id'];
        $DataQltour = $this->indexModel->findTour($id);
        require_once './views/admin/edit-qltour.php';
    }
    public function updateqltour()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => $_POST['name'],
                'category' => $_POST['category'],
                'description' => $_POST['description'],
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date'],
                'price' => $_POST['price'],
                'status' => $_POST['status'],
            ];
            $id = $_POST['id'];
            $return = $this->indexModel->updateqltour($id, $data);
            if ($return) {
                header("Location: index.php?act=QlTour");
            } else {
                echo "Cập nhật thất bại";
            }
        }
    }
    public function deleteQltour($id)
    {
        $id = $_GET['id'];
        $return = $this->indexModel->deleteQltour($id);
        if ($return) {
            header("Location: index.php?act=QlTour");
        } else {
            echo "Xóa thất bại";
        }
    }
    public function addQltour()
    {
        require_once './views/admin/add-qltour.php';
    }
}
