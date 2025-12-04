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

                // 1. Tạo booking
                $booking_id = $this->BookingModel->createBooking([
                    'tour_id' => $tour_id,
                    'guide_id' => $guide_id,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'special_request' => $special_request
                ]);

                // 2. ✅ XỬ LÝ TRANSPORTS (Phương tiện)
                if (isset($_POST['transports']) && is_array($_POST['transports'])) {
                    foreach ($_POST['transports'] as $transport) {
                        // Bỏ qua nếu không có dữ liệu
                        if (empty($transport['type']) && empty($transport['company'])) {
                            continue;
                        }

                        $data = [
                            'type' => $transport['type'] ?? '',
                            'company' => $transport['company'] ?? '',
                            'seats' => $transport['seats'] ?? 0
                        ];

                        $this->BookingModel->createTransports($booking_id, $data);
                    }
                }

                // 3. ✅ XỬ LÝ ACCOMMODATIONS (Khách sạn)
                if (isset($_POST['accommodations']) && is_array($_POST['accommodations'])) {
                    foreach ($_POST['accommodations'] as $accommodation) {
                        // Bỏ qua nếu không có dữ liệu
                        if (empty($accommodation['name'])) {
                            continue;
                        }

                        $data = [
                            'name' => $accommodation['name'] ?? '',
                            'address' => $accommodation['address'] ?? '',
                            'type' => $accommodation['type'] ?? ''
                        ];

                        $this->BookingModel->createAccommodations($booking_id, $data);
                    }
                }

                // 4. ✅ XỬ LÝ PEOPLE (Người tham gia)
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

            header("Location: index.php?act=bookings&msg=success");
            exit;
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
        // Debug
        error_log("POST transports: " . print_r($_POST['transports'] ?? 'EMPTY', true));

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
                'seats' => $transport['seats'] ?? 0,
                'license_plate' => $transport['license_plate'] ?? '',
                'driver_cccd' => $transport['driver_cccd'] ?? '',
                'driver_name' => $transport['driver_name'] ?? '',
                'driver_phone' => $transport['driver_phone'] ?? '',
                'driver_birthdate' => !empty($transport['driver_birthdate']) ? $transport['driver_birthdate'] : null
            ];

            // ✅ KIỂM TRA ID CÓ TỒN TẠI VÀ LÀ SỐ THỰC SỰ
            if (isset($transport['id']) && !empty($transport['id']) && is_numeric($transport['id'])) {
                // ĐÃ TỒN TẠI -> UPDATE
                $keepIds[] = $transport['id'];
                $this->BookingModel->updateTransports($transport['id'], $bookingId, $data);
                error_log("✅ Updated transport ID: {$transport['id']}");
            } else {
                // CHƯA TỒN TẠI -> CREATE MỚI
                $newId = $this->BookingModel->createTransports($bookingId, $data);
                $keepIds[] = $newId;
                error_log("✅ Created new transport ID: {$newId}");
            }
        }

        // Xóa những cái không còn trong form
        $this->BookingModel->deleteTransports($bookingId, $keepIds);
        error_log("✅ Kept transport IDs: " . implode(', ', $keepIds));
    }

    // ==========================================
    // XỬ LÝ ACCOMMODATIONS - Chỗ ở
    // ==========================================

    private function handleAccommodations($bookingId)
    {
        if (!isset($_POST['accommodations'])) {
            return;
        }

        $keepIds = [];

        foreach ($_POST['accommodations'] as $accommodation) {
            if (empty($accommodation['name'])) {
                continue;
            }

            $data = [
                'name' => $accommodation['name'] ?? '',
                'address' => $accommodation['address'] ?? '',
                'type' => $accommodation['type'] ?? '',
                'sdt' => $accommodation['sdt'] ?? ''
            ];

            if (isset($accommodation['id']) && !empty($accommodation['id'])) {
                // UPDATE
                $keepIds[] = $accommodation['id'];
                $this->BookingModel->updateAccommodations($accommodation['id'], $bookingId, $data);
            } else {
                // CREATE
                $this->BookingModel->createAccommodations($bookingId, $data);
                $keepIds[] = $this->BookingModel->getLastInsertId();
            }
        }

        $this->BookingModel->deleteAccommodations($bookingId, $keepIds);
    }

    // ==========================================
    // XỬ LÝ PEOPLE - Người tham gia
    // ==========================================

    private function handlePeople($bookingId)
    {
        // ✅ ĐỔI TỪNG people THÀNH peoples
        if (!isset($_POST['peoples'])) {
            return;
        }

        $keepIds = [];

        foreach ($_POST['peoples'] as $person) {
            // Kiểm tra có dữ liệu không
            if (empty($person['fullname']) && empty($person['phone'])) {
                continue;
            }

            $data = [
                'fullname' => $person['fullname'] ?? '',
                'phone' => $person['phone'] ?? '',
                'date' => $person['date'] ?? date('Y-m-d'),
                'cccd' => $person['cccd'] ?? ''
            ];

            if (!empty($person['id']) && is_numeric($person['id'])) {
                // UPDATE - chỉ update khi ID là số thật
                $keepIds[] = $person['id'];
                $this->BookingModel->updatePeople($person['id'], $bookingId, $data);
            } else {
                // CREATE
                $this->BookingModel->createPeople($bookingId, $data);
                $keepIds[] = $this->BookingModel->getLastInsertId();
            }
        }

        $this->BookingModel->deletePeople($bookingId, $keepIds);
    }

    // ==========================================
    // XÓA BOOKING
    // ==========================================

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
