<?php
require_once './models/guides/IndexGuideModel.php';

class GuidesController
{
    public $conn;
    public $GuidesModel;
    public function __construct()
    {
        $this->conn = connectDB();
        $this->GuidesModel = new GuidesModel();
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
}
