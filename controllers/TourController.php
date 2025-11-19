<?php
require_once './models/TourModel.php';
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
        if ($user  && password_verify($password_hash, $user['password'])) {
            $_SESSION['guide'] = $user;
            $username = $_SESSION['guide']['username'];

            if ($user['role'] === 'admin') {
                header('Location: ?act=admin');
                exit;
            } else {
                header('Location: hdv.php');
                exit;
            }
        } else {
            echo "<script>alert('Sai email hoặc mật khẩu'); window.location.href='?act=login';</script>";
            exit;
        }
    }
    // exit(1);

}
