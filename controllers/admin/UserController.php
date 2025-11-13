<?php
require_once 'models/admin/UserModel.php';

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // Hiển thị danh sách tài khoản
    public function index()
    {
        $users = $this->userModel->getAllUsers();
        // echo "<pre>";
        // print_r($users);
        require_once 'views/admin/tables.php';
    }

    // Hiển thị form thêm tài khoản
    public function create()
    {
        require_once 'views/admin/user-create.php';
    }

    // Xử lý thêm tài khoản mới
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];

            // Validate dữ liệu
            if (empty($_POST['username'])) {
                $errors[] = "Tên đăng nhập không được để trống";
            } elseif ($this->userModel->usernameExists($_POST['username'])) {
                $errors[] = "Tên đăng nhập đã tồn tại";
            }

            if (empty($_POST['email'])) {
                $errors[] = "Email không được để trống";
            } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email không hợp lệ";
            } elseif ($this->userModel->emailExists($_POST['email'])) {
                $errors[] = "Email đã tồn tại";
            }

            if (empty($_POST['password'])) {
                $errors[] = "Mật khẩu không được để trống";
            } elseif (strlen($_POST['password']) < 6) {
                $errors[] = "Mật khẩu phải có ít nhất 6 ký tự";
            }

            if (empty($_POST['full_name'])) {
                $errors[] = "Họ tên không được để trống";
            }

            // Nếu không có lỗi thì thêm mới
            if (empty($errors)) {
                $data = [
                    'username' => trim($_POST['username']),
                    'email' => trim($_POST['email']),
                    'password' => $_POST['password'],
                    'full_name' => trim($_POST['full_name']),
                    'role' => $_POST['role'] ?? 'user',
                    'status' => $_POST['status'] ?? 'active'
                ];

                if ($this->userModel->createUser($data)) {
                    $_SESSION['success'] = "Thêm tài khoản thành công!";
                    header('Location: index.php?controller=user&action=index');
                    exit();
                } else {
                    $errors[] = "Có lỗi xảy ra khi thêm tài khoản";
                }
            }

            // Nếu có lỗi, lưu vào session và quay lại form
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            header('Location: index.php?controller=user&action=create');
            exit();
        }
    }

    // Hiển thị form sửa tài khoản
    public function edit()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['error'] = "Không tìm thấy tài khoản";
            header('Location: index.php?controller=user&action=index');
            exit();
        }

        $user = $this->userModel->getUserById($id);

        if (!$user) {
            $_SESSION['error'] = "Không tìm thấy tài khoản";
            header('Location: index.php?controller=user&action=index');
            exit();
        }

        require_once 'views/admin/user-edit.php';
    }

    // Xử lý cập nhật tài khoản
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $errors = [];

            if (!$id) {
                $_SESSION['error'] = "Không tìm thấy tài khoản";
                header('Location: index.php?controller=user&action=index');
                exit();
            }

            // Validate dữ liệu
            if (empty($_POST['username'])) {
                $errors[] = "Tên đăng nhập không được để trống";
            } elseif ($this->userModel->usernameExists($_POST['username'], $id)) {
                $errors[] = "Tên đăng nhập đã tồn tại";
            }

            if (empty($_POST['email'])) {
                $errors[] = "Email không được để trống";
            } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email không hợp lệ";
            } elseif ($this->userModel->emailExists($_POST['email'], $id)) {
                $errors[] = "Email đã tồn tại";
            }

            if (!empty($_POST['password']) && strlen($_POST['password']) < 6) {
                $errors[] = "Mật khẩu phải có ít nhất 6 ký tự";
            }

            if (empty($_POST['full_name'])) {
                $errors[] = "Họ tên không được để trống";
            }

            // Nếu không có lỗi thì cập nhật
            if (empty($errors)) {
                $data = [
                    'username' => trim($_POST['username']),
                    'email' => trim($_POST['email']),
                    'password' => $_POST['password'] ?? '',
                    'full_name' => trim($_POST['full_name']),
                    'role' => $_POST['role'] ?? 'user',
                    'status' => $_POST['status'] ?? 'active'
                ];

                if ($this->userModel->updateUser($id, $data)) {
                    $_SESSION['success'] = "Cập nhật tài khoản thành công!";
                    header('Location: index.php?controller=user&action=index');
                    exit();
                } else {
                    $errors[] = "Có lỗi xảy ra khi cập nhật tài khoản";
                }
            }

            // Nếu có lỗi, lưu vào session và quay lại form
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            header('Location: index.php?controller=user&action=edit&id=' . $id);
            exit();
        }
    }

    // Xử lý xóa tài khoản
    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['error'] = "Không tìm thấy tài khoản";
            header('Location: index.php?controller=user&action=index');
            exit();
        }

        if ($this->userModel->deleteUser($id)) {
            $_SESSION['success'] = "Xóa tài khoản thành công!";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi xóa tài khoản";
        }

        header('Location: index.php?controller=user&action=index');
        exit();
    }

    // Tìm kiếm tài khoản
    public function search()
    {
        $keyword = $_GET['keyword'] ?? '';

        if (empty($keyword)) {
            header('Location: index.php?controller=user&action=index');
            exit();
        }

        $users = $this->userModel->searchUsers($keyword);
        require_once 'views/admin/users.php';
    }
}
