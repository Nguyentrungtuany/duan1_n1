<?php
require_once './models/guides/IndexGuideModel.php';
require_once './models/admin/UserModel.php';

class GuidesController
{
    public $conn;
    public $GuidesModel;
    public $userModel;
    public function __construct()
    {
        $this->conn = connectDB();
        $this->GuidesModel = new GuidesModel();
        $this->userModel = new UserModel();
    }
    public function index()
    {


        $user = $_SESSION['user'] ?? null;
        $user_id = $user['id'] ?? null;
        // $model = new IndexModel();
        // $data = $model->index();

        require_once './views/guides/indexGuide.php';
    }
    public function detail()
    {

        $user = $_SESSION['user'] ?? null;
        $user_id = $user['id'] ?? null;
        $data = $this->GuidesModel->jobinformation($user_id);
        $job_status = $this->GuidesModel->jobStatus($user_id);
        require_once './views/guides/jobGuide.php';
    }
    public function rollcall()
    {


        $booking_id = $_GET['id'];
        $user = $_SESSION['user'] ?? null;
        $user_id = $user['id'] ?? null;
        $booking = $this->GuidesModel->getBookingById($booking_id);
        $dataPeople = $this->GuidesModel->booking_people($booking_id);
        require_once './views/guides/rollcall_Guide.php';
    }
    public function account()
    {
        // Lấy lại thông tin mới nhất từ database thay vì dùng session cũ
        $userId = $_SESSION['user']['id'] ?? null;

        if ($userId) {
            // Load lại dữ liệu mới từ database
            $user = $this->userModel->getUserById($userId);

            // Cập nhật lại session với dữ liệu mới
            if ($user) {
                $_SESSION['user'] = $user;
            }
        } else {
            $user = null;
        }

        require_once 'views/guides/accountdetail.php';
    }
}
