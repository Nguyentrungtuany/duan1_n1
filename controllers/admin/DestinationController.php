<?php
require_once './models/admin/DestinationModel.php';

class DestinationController
{
    public $destinationModel;

    public function __construct()
    {
        $this->destinationModel = new DestinationModel();
    }

   
    //  Danh sách điểm đến
   
    public function index()
    {
        $destinations = $this->destinationModel->getAll();
        require_once './views/admin/destinations/list.php';
    }

   
    //  Form thêm mới
   
    public function create()
    {
        require_once './views/admin/destinations/add.php';
    }

   
    //  Lưu dữ liệu thêm mới
   
    public function store()
    {
        if (isset($_POST['add'])) {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $location = $_POST['location'];

            $this->destinationModel->insert($name, $description, $location);
        }

        header("Location: ?act=destination-index");
        exit();
    }

   
    //  Form sửa
    
    public function edit()
    {
        $id = $_GET['id'];
        $destination = $this->destinationModel->getOne($id);

        require_once './views/admin/destinations/edit.php';
    }

   
    //  Cập nhật dữ liệu
   
    public function update()
    {
        if (isset($_POST['update'])) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $location = $_POST['location'];

            $this->destinationModel->update($id, $name, $description, $location);
        }

        header("Location: ?act=destination-index");
        exit();
    }

    
}
