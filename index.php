<?php
// Require toàn bộ các file khai báo môi trường, thực thi,...(không require view)

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/TourController.php';
require_once './controllers/admin/IndexController.php';

// Require toàn bộ file Models
require_once './models/TourModel.php';
require_once './models/admin/IndexModel.php';
// Require toàn bộ file Views
// require_once './views/home.php';

// Route
$act = $_GET['act'] ?? '/';


// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($act) {
    // Trang chủ
    '/' => (new TourController())->home(),
    'login' => (new TourController())->Login(),
    'handleLogin' => (new TourController())->handleLogin(),
    'admin' => (new IndexController())->index(),
    'QlTour' => (new IndexController())->QlTuor(),
    'editqltour' => (new IndexController())->editQltour($id),
    'updateqltour' => (new IndexController())->updateQltour(),
    'deleteqltour' => (new IndexController())->deleteQltour($id),
    'addqltour' => (new IndexController())->addQltour(),
    'createTour' => (new IndexController())->createQltour(),
    'test' => (new IndexController())->test(),
    default => require_once './views/404.php'
};
