<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* =======================================================
    REQUIRE COMMON
======================================================= */
require_once './commons/env.php';
require_once './commons/function.php';
require_once './commons/auth.php';

/* =======================================================
    REQUIRE CONTROLLERS
======================================================= */
require_once './controllers/TourController.php';
require_once './controllers/admin/IndexController.php';
require_once './controllers/admin/CategoryController.php';
require_once './controllers/admin/UserController.php';
require_once './controllers/admin/BookingController.php';
require_once './controllers/admin/AdminGuideController.php';
require_once './controllers/admin/GuideController.php';
require_once './controllers/admin/DestinationController.php';
require_once './controllers/guides/GuidesController.php';
require_once './controllers/guides/PostTuorReportController.php';
require_once './controllers/admin/AdminReportController.php';

/* =======================================================
    REQUIRE MODELS
======================================================= */
require_once './models/TourModel.php';
require_once './models/admin/IndexModel.php';
require_once './models/admin/UserModel.php';
require_once './models/admin/BookingModel.php';
require_once './models/guides/IndexGuideModel.php';
require_once './models/guides/PostTourReportModel.php';   // ⭐ THÊM MODEL BÁO CÁO

/* =======================================================
    ROUTE CONFIG
======================================================= */
$act = $_GET['act'] ?? '/';
$id = $_GET['id'] ?? null;

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
    'bookings-create',
    'bookings-edit',
    'bookings-delete',
    'bookings-detail',

    'destination-index',
    'destination-add',
    'destination-update',
    'destination-insert',
    'destination-edit',
    'destination-delete',
    'destination-detail',

    'get-available-people',
    'check-person-conflict',
    'check-guide-conflict-api',
    'get-available-guides-api',
    'get-available-people-api',


    'admin-reports',


    
];

$routeguide = [
    'guide',
    'job-guide',
    'rollcall_Guide',

    // ⭐ ROUTE REPORT TOUR
    'bao-cao-booking',
    'gui-bao-cao-tour',
];

/* =======================================================
    CHECK ROLE
======================================================= */
if (in_array($act, $routeguide)) {
    Auth::checkguide();
}

if (in_array($act, $routeadmin)) {
    Auth::checkadmin();
}

/* =======================================================
    ROUTE HANDLER
======================================================= */

$db = connectDB();

match ($act) {

    /* ---------- TRANG CHỦ ---------- */
    '/' => (new TourController())->home(),
    'login' => (new TourController())->Login(),
    'handleLogin' => (new TourController())->handleLogin(),
    'logout' => (new TourController())->logout(),

    /* ---------- ADMIN ---------- */
    'admin' => (new IndexController())->index(),

    // Users
    'tables' => (new UserController($db))->index(),
    'admin-list-user' => (new UserController($db))->index(),
    'user-create' => (new UserController($db))->create(),
    'user-store' => (new UserController($db))->store(),
    'admin-edit-user' => (new UserController($db))->edit(),
    'admin-update-user' => (new UserController($db))->update(),
    'admin-delete-user' => (new UserController($db))->delete(),
    'user-search' => (new UserController($db))->search(),

    // Tour
    'QlTour' => (new IndexController())->QlTuor(),
    'editqltour' => (new IndexController())->editQltour($id),
    'updateqltour' => (new IndexController())->updateQltour(),
    'deleteqltour' => (new IndexController())->deleteQltour($id),
    'addqltour' => (new IndexController())->addQltour(),
    'createTour' => (new IndexController())->createQltour(),

    // Category
    'category' => (new CategoryController())->index(),
    'category-add' => (new CategoryController())->add(),
    'category-insert' => (new CategoryController())->handleAdd(),
    'category-edit' => (new CategoryController())->edit(),
    'category-update' => (new CategoryController())->handleEdit(),
    'category-delete' => (new CategoryController())->delete(),

    // Booking
    'bookings' => (new BookingController())->index(),
    'bookings-edit' => (new BookingController())->edit(),
    'bookings-update' => (new BookingController())->update(),
    'bookings-add' => (new BookingController())->add(),
    'bookings-create' => (new BookingController())->create(),
    'bookings-delete' => (new BookingController())->delete(),
    'bookings-detail' => (new BookingController())->detail(),

    // Destination
    'destination-index' => (new DestinationController())->index(),
    'destination-create' => (new DestinationController())->create(),
    'destination-insert' => (new DestinationController())->store(),
    'destination-edit' => (new DestinationController())->edit(),
    'destination-update' => (new DestinationController())->update(),
    'destination-delete' => (new DestinationController())->delete(),

    // API
    'get-available-people' => (new BookingController())->getAvailablePeopleApi(),
    'check-person-conflict' => (new BookingController())->checkPersonConflictApi(),
    'check-guide-conflict-api' => (new BookingController())->checkGuideConflictApi(),
    'get-available-guides-api' => (new BookingController())->getAvailableGuidesApi(),
    'get-available-people-api' => (new BookingController())->getAvailablePeopleApi(),

    /* ---------- HƯỚNG DẪN VIÊN ---------- */
    'guide' => (new GuidesController())->index(),
    'job-guide' => (new GuidesController())->detail(),
    'rollcall_Guide' => (new GuidesController())->rollcall(),

    // ⭐ FORM BÁO CÁO TOUR
    'bao-cao-booking' => (new PostTuorReportController())->index(),
    // ⭐ SUBMIT REPORT
    'gui-bao-cao-tour' => (new PostTuorReportController())->store(),
    
    'admin-reports' => (new AdminReportController())->index(),


    /* ---------- 404 ---------- */
    default => require_once './views/404.php',
};
