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

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $user = $_SESSION['user'] ?? null;
        $user_id = $user['id'] ?? null;
        // $model = new IndexModel();
        // $data = $model->index();

        require_once './views/guides/indexGuide.php';
    }
    public function detail()
    {
        require_once './views/guides/jobGuide.php';
    }
}
