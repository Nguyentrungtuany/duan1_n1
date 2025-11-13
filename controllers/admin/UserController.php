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
        require_once './views/admin/list-user.php';
    }

    // Hiển thị form thêm tài khoản
    public function create()
    {
        require_once './views/admin/user-create.php';
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
                    'phone' => trim($_POST['phone'] ?? ''),
                    'role' => $_POST['role'] ?? 'guide',
                    'status' => $_POST['status'] ?? 'active'
                ];

                if ($this->userModel->createUser($data)) {
                    $_SESSION['success'] = "Thêm tài khoản thành công!";
                    header("Location:" . BASE_URL . "?act=admin-list-user");
                    exit();
                } else {
                    $errors[] = "Có lỗi xảy ra khi thêm tài khoản";
                }
            }

            // Nếu có lỗi, lưu vào session và quay lại form
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            header("Location:" . BASE_URL . "?act=user-create");
            exit();
        }
    }

    // Hiển thị form sửa tài khoản
    public function edit()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['error'] = "Không tìm thấy tài khoản";
            header("Location:" . BASE_URL . "?act=admin-list-user");
            exit();
        }

        $user = $this->userModel->getUserById($id);

        if (!$user) {
            $_SESSION['error'] = "Không tìm thấy tài khoản";
            header("Location:" . BASE_URL . "?act=admin-list-user");
            exit();
        }

        require_once './views/admin/update-user.php';
    }

    // Xử lý cập nhật tài khoản
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $errors = [];

            if (!$id) {
                $_SESSION['error'] = "Không tìm thấy tài khoản";
                header("Location:" . BASE_URL . "?act=admin-edit-user");
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
                    'password' => !empty($_POST['password']) ? $_POST['password'] : '',
                    'full_name' => trim($_POST['full_name']),
                    'phone' => trim($_POST['phone'] ?? ''),
                    'address' => trim($_POST['address'] ?? ''),
                    'role' => $_POST['role'] ?? 'guide',
                    'status' => $_POST['status'] ?? 'active'
                ];

                if ($this->userModel->updateUser($id, $data)) {
                    $_SESSION['success'] = "Cập nhật tài khoản thành công!";
                    header("Location:" . BASE_URL . "?act=admin-list-user");
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
            header("Location:" . BASE_URL . "?act=admin-list-user");
            exit();
        }

        if ($this->userModel->deleteUser($id)) {
            $_SESSION['success'] = "Xóa tài khoản thành công!";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi xóa tài khoản";
        }

        header("Location:" . BASE_URL . "?act=admin-list-user");
        exit();
    }

    // Tìm kiếm tài khoản
    public function search()
    {
        $keyword = $_GET['keyword'] ?? '';

        if (empty($keyword)) {
            header("Location:" . BASE_URL . "?act=admin-list-user");
            exit();
        }

        $users = $this->userModel->searchUsers($keyword);
        require_once 'views/admin/users.php';
    }
}
