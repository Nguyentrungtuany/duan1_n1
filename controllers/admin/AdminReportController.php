<?php
require_once './models/admin/AdminReportModel.php';

class AdminReportController
{
    private $model;

    public function __construct()
    {
        $this->model = new AdminReportModel();
    }

    public function index()
    {
        $reports = $this->model->getAllReports();
        require_once './views/admin/reports/list.php';
    }

    public function detail()
    {
        $id = $_GET['id'] ?? 0;
        $report = $this->model->getOneReport($id);

        require_once './views/admin/reports/detail.php';
    }
}
