<?php
require_once './models/admin/CategoryModel.php';

class CategoryController
{
    public $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    // Trang danh sách
    public function index()
    {
        $categories = $this->categoryModel->getAll();
        require_once './views/admin/category/list.php';
    }

    // Trang thêm mới
    public function add()
    {
        require_once './views/admin/category/add.php';
    }

    // Xử lý thêm mới
    public function handleAdd()
    {
        $name = $_POST['name'];
        $description = $_POST['description'];

        if (empty($name)) {
            echo "<script>alert('Tên danh mục không được để trống'); window.location.href='?act=category-add';</script>";
            exit;
        }

        $this->categoryModel->insert($name, $description);
        header("Location: ?act=category");
        exit;
    }

    // Trang sửa
    public function edit()
    {
        $id = $_GET['id'];
        $category = $this->categoryModel->find($id);

        if (!$category) {
            header("Location: ?act=category");
            exit;
        }

        require_once './views/admin/category/edit.php';
    }

    // Xử lý sửa
    public function handleEdit()
    {
        // var_dump($_POST);
        // exit(1);
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];

        if (empty($name)) {
            echo "<script>alert('Tên danh mục không được để trống'); window.location.href='?act=category-edit&id=$id';</script>";
            exit;
        }

        $this->categoryModel->update($id, $name, $description);
        header("Location: ?act=category");
        exit;
    }

    // Xóa
    public function delete()
    {
        $id = $_GET['id'];
        $this->categoryModel->delete($id);

        header("Location: ?act=category");
        exit;
    }
}
