<?php
require_once './models/admin/BookingModel.php';

class BookingController
{
    public $BookingModel;

    public function __construct()
    {
        $this->BookingModel = new BookingModel();
    }

    // ==========================================
    // HIỂN THỊ TRANG
    // ==========================================

    public function index()
    {
        $bookings = $this->BookingModel->getAllBookings();
        require_once './views/admin/booking/list.php';
    }

    public function detail()
    {
        $id = $_GET['id'];
        $booking = $this->BookingModel->getBookingById($id);
        require_once './views/admin/booking/detail.php';
    }

    public function edit()
    {
        $id = $_GET['id'];
        $booking = $this->BookingModel->getBookingById($id);
        $allCategory = $this->BookingModel->allCategory();
        $allDestination = $this->BookingModel->allDestination();
        $allTour = $this->BookingModel->allTour();
        $allGuide = $this->BookingModel->allGuide();
        require_once './views/admin/booking/edit.php';
    }

    public function add()
    {
        $allCategory = $this->BookingModel->allCategory();
        $allDestination = $this->BookingModel->allDestination();
        $allTour = $this->BookingModel->allTour();
        $allGuide = $this->BookingModel->allGuide();
        require_once './views/admin/booking/add.php';
    }

    // ==========================================
    // TẠO MỚI BOOKING
    // ==========================================

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $tour_id = $_POST['tour_id'];
                $guide_id = $_POST['guide_id'] ?? null;
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                $special_request = $_POST['special_request'] ?? '';

                // Tạo booking - ✅ THÊM guide_id VÀO ĐÂY
                $booking_id = $this->BookingModel->createBooking([
                    'tour_id' => $tour_id,
                    'guide_id' => $guide_id,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'special_request' => $special_request
                ]);

                // ✅ XỬ LÝ PEOPLE GIỐNG NHƯ UPDATE
                if (isset($_POST['peoples']) && is_array($_POST['peoples'])) {
                    foreach ($_POST['peoples'] as $person) {
                        // Bỏ qua nếu không có dữ liệu
                        if (empty($person['fullname']) && empty($person['phone'])) {
                            continue;
                        }

                        $data = [
                            'fullname' => $person['fullname'] ?? '',
                            'phone' => $person['phone'] ?? '',
                            'date' => $person['date'] ?? date('Y-m-d'),
                            'cccd' => $person['cccd'] ?? ''
                        ];

                        $this->BookingModel->createPeople($booking_id, $data);
                    }
                }

                header("Location: index.php?act=bookings&msg=created");
                exit();
            } catch (Exception $e) {
                echo "Lỗi tạo booking: " . $e->getMessage();
                error_log("Booking Create Error: " . $e->getMessage());
            }
        }
    }

    // ==========================================
    // CẬP NHẬT BOOKING
    // ==========================================

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header("Location: index.php?act=bookings");
            exit;
        }

        // exit();

        try {
            $id = $_POST['id'];

            // 1. Cập nhật booking chính
            $bookingData = [
                'tour_id' => $_POST['tour_id'],
                'guide_id' => $_POST['guide_id'],
                'payment_status' => $_POST['payment_status'],
                'status' => $_POST['status'],
                'special_request' => $_POST['special_request'],
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date']
            ];
            $this->BookingModel->updateBooking($id, $bookingData);

            // 2. Xử lý TRANSPORTS (Phương tiện)
            $this->handleTransports($id);

            // 3. Xử lý ACCOMMODATIONS (Chỗ ở)
            $this->handleAccommodations($id);

            // 4. Xử lý PEOPLE (Người tham gia)
            $this->handlePeople($id);

            header("Location: index.php?act=bookings");
            // exit;
        } catch (Exception $e) {
            echo "Lỗi cập nhật: " . $e->getMessage();
            error_log("Booking Update Error: " . $e->getMessage());
        }
    }

    // ==========================================
    // XỬ LÝ TRANSPORTS - Phương tiện
    // ==========================================

    private function handleTransports($bookingId)
    {
        if (!isset($_POST['transports'])) {
            return;
        }

        $keepIds = []; // Danh sách ID cần giữ lại

        foreach ($_POST['transports'] as $transport) {
            // Kiểm tra có dữ liệu không
            if (empty($transport['type']) && empty($transport['company'])) {
                continue;
            }

            $data = [
                'type' => $transport['type'] ?? '',
                'company' => $transport['company'] ?? '',
                'seats' => $transport['seats'] ?? 0
            ];

            if (isset($transport['id']) && !empty($transport['id'])) {
                // ĐÃ TỒN TẠI -> UPDATE
                $keepIds[] = $transport['id'];
                $this->BookingModel->updateTransports($transport['id'], $bookingId, $data);
            } else {
                // CHƯA TỒN TẠI -> CREATE MỚI
                $this->BookingModel->createTransports($bookingId, $data);
                $keepIds[] = $this->BookingModel->getLastInsertId();
            }
        }

        // Xóa những cái không còn trong form
        $this->BookingModel->deleteTransports($bookingId, $keepIds);
    }

    // ==========================================
    // XỬ LÝ ACCOMMODATIONS - Chỗ ở
    // ==========================================

    private function handleAccommodations($bookingId)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?act=bookings");
            exit;
        }

        try {
            // 1. Tạo booking chính với đầy đủ thông tin
            $bookingData = [
                'tour_id' => $_POST['tour_id'],
                'guide_id' => $_POST['guide_id'],
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date'],
                'special_request' => $_POST['special_request'] ?? '',
                'status' => $_POST['status'] ?? 'pending',
            ];

            $booking_id = $this->BookingModel->createBooking($bookingData);

            // ===== XỬ LÝ TRANSPORTS =====
            if (isset($_POST['transports']) && is_array($_POST['transports'])) {
                foreach ($_POST['transports'] as $transport) {
                    // Chỉ thêm nếu có dữ liệu
                    if (!empty($transport['type']) || !empty($transport['company'])) {
                        $data = [
                            'booking_id' => $booking_id,
                            'type' => $transport['type'] ?? '',
                            'company' => $transport['company'] ?? '',
                            'seats' => $transport['seats'] ?? 0,
                        ];
                        $this->BookingModel->createTransports($booking_id, $data);
                    }
                }
            }

            // ===== XỬ LÝ ACCOMMODATIONS =====
            if (isset($_POST['accommodations']) && is_array($_POST['accommodations'])) {
                foreach ($_POST['accommodations'] as $accommodation) {
                    if (!empty($accommodation['name'])) {
                        $data = [
                            'booking_id' => $booking_id,
                            'name' => $accommodation['name'] ?? '',
                            'address' => $accommodation['address'] ?? '',
                            'type' => $accommodation['type'] ?? '',
                        ];
                        $this->BookingModel->createAccommodations($booking_id, $data);
                    }
                }
            }

            // ===== XỬ LÝ SCHEDULES =====
            if (isset($_POST['schedules']) && is_array($_POST['schedules'])) {
                foreach ($_POST['schedules'] as $schedule) {
                    if (!empty($schedule['location']) || !empty($schedule['activities'])) {
                        $data = [
                            'booking_id' => $booking_id,
                            'day_number' => $schedule['day_number'] ?? 1,
                            'date' => $schedule['date'] ?? null,
                            'location' => $schedule['location'] ?? '',
                            'activities' => $schedule['activities'] ?? '',
                            'notes' => $schedule['notes'] ?? '',
                        ];
                        $this->BookingModel->createSchedules($booking_id, $data);
                    }
                }
            }

            // ===== XỬ LÝ PEOPLE =====
            if (isset($_POST['peoples']) && is_array($_POST['peoples'])) {
                foreach ($_POST['peoples'] as $person) {
                    // Kiểm tra có tên và số điện thoại
                    if (!empty($person['fullname']) && !empty($person['phone'])) {
                        $data = [
                            'booking_id' => $booking_id,
                            'fullname' => $person['fullname'],
                            'date' => $person['date'] ?? null,
                            'phone' => $person['phone'],
                        ];
                        $this->BookingModel->addPerson($data);
                    }
                }
            }

            header("Location: index.php?act=bookings");
            exit();
        } catch (Exception $e) {
            echo "Lỗi tạo booking: " . $e->getMessage();
            error_log("Booking Create Error: " . $e->getMessage());
        }
    }
    public function delete()
    {
        $id = $_GET['id'];
        $return = $this->BookingModel->delete($id);

        if ($return) {
            header("Location: index.php?act=bookings");
        } else {
            echo "Xóa thất bại";
        }
    }
}
