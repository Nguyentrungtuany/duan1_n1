<?php
require_once './models/admin/DashboardModel.php';
require_once './models/admin/IndexModel.php';
class IndexController
{
    public $indexModel;
    public $dashboardModel;
    public function __construct()
    {
        $this->indexModel = new IndexModel();
        $this->dashboardModel = new DashboardModel();
    }
    public function index()
    {
        $bookingDone = $this->dashboardModel->getBookingDone();
        $bookingOngoing = $this->dashboardModel->getBookingOngoing();
        $totalCustomers = $this->dashboardModel->getTotalCustomers();
        $totalGuides = $this->dashboardModel->getTotalGuides();
        $totalRevenue = $this->dashboardModel->getTotalRevenue();


        require_once './views/admin/IndexAdmin.php';
    }
    public function QlTuor()
    {
        $DataQltour = $this->indexModel->QlTour();
        // print_r($DataQltour);
        require_once './views/admin/qltour.php';
    }
    public function editQltour($id)
    {
        // $DataQltour = $this->indexModel->QlTour();
        $id = $_GET['id'];
        $DataQltour = $this->indexModel->findTour($id);
        $allCategory = $this->indexModel->allCategory();
        $allDestination = $this->indexModel->allDestination();
        require_once './views/admin/edit-qltour.php';
    }
    public function updateqltour()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => $_POST['name'],
                'category_id' => $_POST['category_id'],
                'destination_id' => $_POST['destination_id'], // ✅ THÊM DÒNG NÀY
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'status' => $_POST['status'],
                'transports' => [],
                'accommodations' => [],
                'schedules' => [],
            ];
            $id = $_POST['id'];
            $return = $this->indexModel->updateqltour($id, $data);

            if (isset($_POST['transports'])) {
                $Idtransports = [];
                foreach ($_POST['transports'] as $transport) {
                    if (isset($transport['id']) && !empty($transport['id'])) {
                        $data = [
                            'type' => $transport['type'],
                            'company' => $transport['company'],
                            'seats' => $transport['seats'],
                        ];
                        $this->indexModel->updatetransports($id, $data);
                    } else {
                        $data = [
                            'type' => $transport['type'],
                            'company' => $transport['company'],
                            'seats' => $transport['seats'],
                            'tour_id' => $id,
                        ];
                        $this->indexModel->createtransports($id, $data);
                        $newId = $this->indexModel->getLastInsertId();
                        $Idtransports[] = $newId;
                    }
                }
                $this->indexModel->deletetransports($id, $Idtransports);
            }
            if (isset($_POST['accommodations'])) {
                $Idaccommodations = [];
                foreach ($_POST['accommodations'] as $accommodation) {
                    if (isset($accommodation['id']) && !empty($accommodation['id'])) {
                        $Idaccommodations[] = $accommodation['id'];
                        $data = [
                            'name' => $accommodation['name'],
                            'address' => $accommodation['address'],
                            'type' => $accommodation['type'],
                        ];
                        $this->indexModel->updateaccommodations($id, $data);
                    } else {
                        $data = [
                            'name' => $accommodation['name'],
                            'address' => $accommodation['address'],
                            'type' => $accommodation['type'],
                            'tour_id' => $id,
                        ];
                        $this->indexModel->createaccommodations($id, $data);
                        $newId = $this->indexModel->getLastInsertId();
                        $Idaccommodations[] = $newId;
                    }
                }
                $this->indexModel->deleteaccommodations($id, $Idaccommodations);
            }
        }
        // echo "<pre>";
        // var_dump($_POST['schedules']);
        // echo "</pre>";
        // exit(1);
        if (isset($_POST['schedules'])) {
            $Idschedules = [];
            foreach ($_POST['schedules'] as $schedule) {
                if (isset($schedule['id']) && !empty($schedule['id'])) {
                    $Idschedules[] = $schedule['id'];

                    $data = [
                        'day_number' => $schedule['day_number'],
                        'location' => $schedule['location'],
                        'activities' => $schedule['activities'],
                        'notes' => $schedule['notes'],
                    ];
                    $this->indexModel->updateschedules($schedule['id'], $id, $data);
                } else {

                    $data = [
                        'tour_id' => $id,
                        'day_number' => $schedule['day_number'],
                        'location' => $schedule['location'],
                        'activities' => $schedule['activities'],
                        'notes' => $schedule['notes'],
                    ];
                    $this->indexModel->createshedules($id, $data);
                    $newId = $this->indexModel->getLastInsertId();
                    $Idschedules[] = $newId;
                }
            }
            $this->indexModel->deleteshedules($id, $Idschedules);
        }
        if ($return) {
            header("Location: index.php?act=QlTour");
        } else {
            echo "Cập nhật thất bại";
        }
    }

    public function deleteQltour($id)
    {
        $id = $_GET['id'];
        $return = $this->indexModel->deleteQltour($id);
        if ($return) {
            header("Location: index.php?act=QlTour");
        } else {
            echo "Xóa thất bại";
        }
    }
    public function addQltour()
    {
        $allCategory = $this->indexModel->allCategory();
        $allDestination = $this->indexModel->allDestination();
        require_once './views/admin/add-qltour.php';
    }
    public function createQltour()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'category_id' => $_POST['category_id'],
                'destination_id' => $_POST['destination_id'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'status' => $_POST['status'],
            ];

            // Tạo tour mới
            $return = $this->indexModel->createQltour($data);

            if ($return) {
                // Lấy ID của tour vừa tạo
                $tourId = $this->indexModel->getLastInsertId();

                // Xử lý lưu lịch trình nếu có
                if (isset($_POST['schedules']) && is_array($_POST['schedules'])) {
                    foreach ($_POST['schedules'] as $schedule) {
                        $scheduleData = [
                            'tour_id' => $tourId,
                            'day_number' => $schedule['day_number'],
                            'location' => $schedule['location'] ?? '',
                            'activities' => $schedule['activities'] ?? '',
                            'notes' => $schedule['notes'] ?? '',
                        ];
                        $this->indexModel->createshedules($tourId, $scheduleData);
                    }
                }

                header("Location: index.php?act=QlTour");
                exit();
            } else {
                echo "Thêm mới thất bại";
            }
        }
    }
    public function test()
    {
        // Lấy dữ liệu thật từ database
        $mapData = $this->indexModel->getMapData();

        // ✅ NẾU KHÔNG CÓ DỮ LIỆU, DÙNG DỮ LIỆU MẪU
        if (empty($mapData)) {
            $mapData = [
                ['country' => 'Vietnam', 'location' => 'Hà Nội, TP.HCM', 'total_bookings' => 25, 'total_customers' => 75],
                ['country' => 'Thailand', 'location' => 'Bangkok, Phuket', 'total_bookings' => 18, 'total_customers' => 54],
                ['country' => 'Japan', 'location' => 'Tokyo, Osaka', 'total_bookings' => 15, 'total_customers' => 45],
                ['country' => 'South Korea', 'location' => 'Seoul, Busan', 'total_bookings' => 12, 'total_customers' => 36],
                ['country' => 'Singapore', 'location' => 'Singapore', 'total_bookings' => 10, 'total_customers' => 30],
                ['country' => 'China', 'location' => 'Beijing, Shanghai', 'total_bookings' => 20, 'total_customers' => 60],
                ['country' => 'Malaysia', 'location' => 'Kuala Lumpur', 'total_bookings' => 8, 'total_customers' => 24],
                ['country' => 'Indonesia', 'location' => 'Bali, Jakarta', 'total_bookings' => 14, 'total_customers' => 42],
                ['country' => 'Philippines', 'location' => 'Manila, Boracay', 'total_bookings' => 6, 'total_customers' => 18],
                ['country' => 'Cambodia', 'location' => 'Siem Reap, Phnom Penh', 'total_bookings' => 5, 'total_customers' => 15],
                ['country' => 'France', 'location' => 'Paris, Nice', 'total_bookings' => 12, 'total_customers' => 36],
                ['country' => 'United States', 'location' => 'New York, LA', 'total_bookings' => 16, 'total_customers' => 48],
                ['country' => 'Australia', 'location' => 'Sydney, Melbourne', 'total_bookings' => 9, 'total_customers' => 27],
                ['country' => 'United Kingdom', 'location' => 'London', 'total_bookings' => 7, 'total_customers' => 21],
                ['country' => 'Germany', 'location' => 'Berlin, Munich', 'total_bookings' => 8, 'total_customers' => 24],
            ];
        }

        $mapDataJson = json_encode($mapData, JSON_UNESCAPED_UNICODE);

        require_once './views/admin/test.php';
    }
}
