<?php
require_once './models/TourModel.php';
require_once './commons/auth.php';


class TourController
{
    public $tourModel;
    public function __construct()
    {
        $this->tourModel = new TourModel();
    }
    public function home()
    {
        require_once './views/home.php';
    }
    public function Login()
    {

        require_once './views/login.php';
    }

    public function handleLogin()
    {
        $email = $_POST['email'];
        $password_hash = $_POST['password'];
        $user = $this->tourModel->findEmail($email);
        // print_r($user);
        // var_dump($password_hash);
        // echo "<pre>";

        //$hash = password_hash($password_hash, PASSWORD_DEFAULT);
        //var_dump($hash);
        //exit(1);

        if (!$user) {
            echo "<script>alert(' email không đúng'); window.location.href='?act=login';</script>";
            exit();
        }
        if (!password_verify($password_hash, $user['password'])) {
            echo "<script>alert('mật khẩu không đúng'); window.location.href='?act=login';</script>";
            exit();
        }
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'] ?? $user['name'] ?? $user['email'],
            'email' => $user['email'],
            'role' => $user['role'], // ← QUAN TRỌNG
        ];

        // Chuyển hướng theo role
        if ($user['role'] === 'admin') {
            header("Location: index.php?act=admin");
            exit();
        } elseif ($user['role'] === 'guide') {
            header("Location: index.php?act=QlTour"); // Guide vào quản lý tour
            exit();
        } else {
            echo "<script>alert('Vai trò không hợp lệ!'); window.location.href='index.php?act=login';</script>";
            exit();
        }
    }
    public function logout()
    {
        session_start(); // Nếu chưa có thì gọi lại
        session_unset(); // Xóa toàn bộ biến session
        session_destroy(); // Hủy session
        header('Location: index.php?act=login');
    }
    // exit(1);

}
