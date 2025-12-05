<?php
require_once __DIR__ . '/../../models/admin/DashboardModel.php';

class DashboardController
{
    private $dashboardModel;

    public function __construct()
    {
        $this->dashboardModel = new DashboardModel();
    }

    public function index()
    {
        try {
            echo "<pre>";
            echo "Booking Done: " . $this->dashboardModel->getBookingDone() . "<br>";
            echo "Booking Ongoing: " . $this->dashboardModel->getBookingOngoing() . "<br>";
            echo "Total Revenue: " . $this->dashboardModel->getTotalRevenue() . "<br>";
            echo "Total Guides: " . $this->dashboardModel->getTotalGuides() . "<br>";
            echo "Total Customers: " . $this->dashboardModel->getTotalCustomers() . "<br>";
            echo "</pre>";
            // Lấy dữ liệu từ model
            $data = [
                'totalBooking'   => $this->dashboardModel->getBookingDone() + $this->dashboardModel->getBookingOngoing(),
                'bookingDone'    => $this->dashboardModel->getBookingDone(),
                'bookingPending' => $this->dashboardModel->getBookingOngoing(),
                'totalRevenue'   => $this->dashboardModel->getTotalRevenue(),
                'totalGuides'    => $this->dashboardModel->getTotalGuides(),
                'totalCustomers' => $this->dashboardModel->getTotalCustomers()
            ];


            require_once __DIR__ . '/../../views/admin/IndexAdmin.php';
        } catch (Exception $e) {
            error_log("Dashboard Error: " . $e->getMessage());
            echo "<h2>Không thể tải dữ liệu dashboard</h2>";
        }
    }
}

// Nếu chạy trực tiếp file này mà không qua router
// $controller = new DashboardController();
// $controller->index();
