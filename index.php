
<?php

session_start();
// Require toàn bộ các file khai báo môi trường, thực thi,...(không require view)

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ
require_once './commons/auth.php';

// Require toàn bộ file Controllers
require_once './controllers/TourController.php';
require_once './controllers/admin/IndexController.php';
require_once './controllers/admin/CategoryController.php';
require_once './controllers/admin/UserController.php';
require_once './controllers/admin/BookingController.php';
require_once './controllers/admin/AdminGuideController.php';
require_once './controllers/admin/GuideController.php';
require_once './controllers/admin/DestinationController.php';

require_once './controllers/guides/GuidesController.php';

// Require toàn bộ file Models
require_once './models/TourModel.php';
require_once './models/admin/IndexModel.php';
require_once './models/admin/UserModel.php';
require_once './models/admin/BookingModel.php';
require_once './models/guides/IndexGuideModel.php';
// Require toàn bộ file Views
// require_once './views/home.php';
// Route
$act = $_GET['act'] ?? '/';
$routeadmin = [
    'admin',
    'tables',
    'admin-list-user',
    'user-create',
    'user-store',
    'admin-edit-user',
    'admin-update-user',
    'admin-delete-user',
    'user-search',
    'QlTour',
    'editqltour',
    'updateqltour',
    'deleteqltour',
    'addqltour',
    'createTour',
    'category',
    'category-add',
    'category-update',
    'category-insert',
    'category-edit',
    'category-delete',
    'bookings',
    'bookings-add',
    'bookings-update',
    'bookings-insert',
    'bookings-edit',
    'bookings-delete',
    'bookings-detail',
    'destination',
    'destination-add',
    'destination-update',
    'destination-insert',
    'destination-edit',
    'destination-delete',
    'destination-detail',
];
$routeguide = [
    'guide',
];

if (in_array($act, $routeadmin)) {
    Auth::checkAdmin();
}
if (in_array($act, $routeguide)) {
    Auth::checkguide();
}

// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match
$db = connectDB();

match ($act) {
    // Trang chủ
    '/' => (new TourController())->home(),
    'login' => (new TourController())->Login(),
    'handleLogin' => (new TourController())->handleLogin(),
    'logout' => (new TourController())->logout(),
    'admin' => (new IndexController())->index(),
    // 'tables' => (new IndexController())->tables(),
    'tables' => (new UserController($db))->index(),
    'admin-list-user' => (new UserController($db))->index(),        // Danh sách
    'user-create' => (new UserController($db))->create(),           // Hiển thị form thêm
    'user-store' => (new UserController($db))->store(),             // Xử lý thêm
    'admin-edit-user' => (new UserController($db))->edit(),               // Hiển thị form sửa
    'admin-update-user' => (new UserController($db))->update(),           // Xử lý cập nhật
    'admin-delete-user' => (new UserController($db))->delete(),     // Xóa
    'user-search' => (new UserController($db))->search(),
    'QlTour' => (new IndexController())->QlTuor(),
    'editqltour' => (new IndexController())->editQltour($id),
    'updateqltour' => (new IndexController())->updateQltour(),
    'deleteqltour' => (new IndexController())->deleteQltour($id),
    'addqltour' => (new IndexController())->addQltour(),
    // 'createTour' => (new IndexController())->createQltour(),
    // Quản lý danh mục
    'category' => (new CategoryController())->index(),
    'category-add' => (new CategoryController())->add(),
    'category-insert' => (new CategoryController())->handleAdd(),
    'category-edit' => (new CategoryController())->edit(),
    'category-update' => (new CategoryController())->handleEdit(),
    'category-delete' => (new CategoryController())->delete(),
    //Quản lý booking
    'bookings' => (new BookingController())->index(),
    'bookings-edit' => (new BookingController())->edit(),
    'bookings-update' => (new BookingController())->update(),
    'bookings-add' => (new BookingController())->add(),
    'bookings-create' => (new BookingController())->create(),
    'bookings-delete' => (new BookingController())->delete(),
    'bookings-detail' => (new BookingController())->detail(),

    //Quản lý hướng dẫn viên
    'admin_guides' => (new GuideController())->index(),
    'admin_guide_create' => (new GuideController())->create(),
    'admin_guide_edit' => (new GuideController())->edit($_GET['id']),
    'admin_guide_update' => (new GuideController())->update($_GET['id'] ?? null),
    // 'admin_guide_delete' => (new GuideController())->delete($_GET['id']),
    // quản lý điểm đến
    'destination-index' => (new DestinationController())->index(),
    'destination-create' => (new DestinationController())->create(),
    'destination-insert' => (new DestinationController())->store(),
    'destination-edit' => (new DestinationController())->edit(),
    'destination-update' => (new DestinationController())->update(),
    'destination-delete' => (new DestinationController())->delete(),

    'createTour' => (new IndexController())->createQltour(),
    'test' => (new IndexController())->test(),
    //Hướng dẫn viên
    'guide' => (new GuidesController())->index(),
    default => require_once './views/404.php',
};
