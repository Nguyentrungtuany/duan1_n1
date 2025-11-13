<?php
// Require file Common
require_once './commons/env.php';
require_once './commons/function.php';

// Require toàn bộ file Controllers
require_once './controllers/TourController.php';
require_once './controllers/admin/IndexController.php';

// Require toàn bộ file Models
require_once './models/TourModel.php';
require_once './models/admin/User.php'; // Thêm dòng này

// Route
$act = $_GET['act'] ?? '/';

match ($act) {
    '/' => (new TourController())->home(),
    'login' => (new TourController())->Login(),
    'handleLogin' => (new TourController())->handleLogin(),
    'admin' => (new IndexController())->index(),
    'tables' => (new IndexController())->tables(),
    default => require_once './views/404.php'
};
?>