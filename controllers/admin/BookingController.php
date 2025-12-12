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
        $seatInfo = $this->BookingModel->checkAvailableSeats($id);

        // ✅ THÊM 2 DÒNG NÀY
        $attendances = $this->BookingModel->getBookingAttendances($id);
        $attendanceSummary = $this->BookingModel->getAttendanceSummaryByDate($id);

        require_once './views/admin/booking/detail.php';
    }

    public function edit()
    {
        $id = $_GET['id'];
        $booking = $this->BookingModel->getBookingById($id);
        $seatInfo = $this->BookingModel->checkAvailableSeats($id);
        $allCategory = $this->BookingModel->allCategory();
        $allDestination = $this->BookingModel->allDestination();
        $allTour = $this->BookingModel->allTour();
        $allGuide = $this->BookingModel->allGuide();

        // ✅ Load danh sách người có sẵn
        $availablePeople = [];
        if (!empty($booking['start_date']) && !empty($booking['end_date'])) {
            $availablePeople = $this->BookingModel->getAvailablePeople(
                $booking['start_date'],
                $booking['end_date'],
                $id
            );
        }

        // ✅ THÊM MỚI: Load danh sách HDV có sẵn
        $availableGuides = [];
        if (!empty($booking['start_date']) && !empty($booking['end_date'])) {
            $availableGuides = $this->BookingModel->getAvailableGuides(
                $booking['start_date'],
                $booking['end_date'],
                $id
            );
        }

        require_once './views/admin/booking/edit.php';
    }

    public function add()
    {
        $allCategory = $this->BookingModel->allCategory();
        $allDestination = $this->BookingModel->allDestination();
        $allTour = $this->BookingModel->allTour();
        $allGuide = $this->BookingModel->allGuide();

        // ✅ FIX: Load danh sách người và HDV có sẵn
        $availablePeople = [];
        $availableGuides = [];

        // Ưu tiên lấy từ GET params (sau khi reload)
        $startDate = $_GET['start_date'] ?? null;
        $endDate = $_GET['end_date'] ?? null;

        if ($startDate && $endDate) {
            // Load danh sách
            $availablePeople = $this->BookingModel->getAvailablePeople($startDate, $endDate, null);
            $availableGuides = $this->BookingModel->getAvailableGuides($startDate, $endDate, null);

            // Log để debug
            error_log("✅ Loaded for add page: " . count($availablePeople) . " people, " . count($availableGuides) . " guides");
        }

        require_once './views/admin/booking/add.php';
    }

    // ==========================================
    // TẠO MỚI BOOKING
    // ==========================================

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?act=bookings");
            exit;
        }

        try {
            $tour_id = $_POST['tour_id'];
            $guide_id = $_POST['guide_id'] ?? null;
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $special_request = $_POST['special_request'] ?? '';
            $max_people = $_POST['max_people'] ?? 30;

            // 1️⃣ TẠO BOOKING
            $booking_id = $this->BookingModel->createBooking([
                'tour_id' => $tour_id,
                'guide_id' => $guide_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'special_request' => $special_request,
                'max_people' => $max_people
            ]);

            // 2️⃣ XỬ LÝ TRANSPORTS (PHƯƠNG TIỆN)
            if (isset($_POST['transports']) && is_array($_POST['transports'])) {
                foreach ($_POST['transports'] as $transport) {
                    // Bỏ qua nếu không có dữ liệu
                    if (empty($transport['type']) && empty($transport['company'])) {
                        continue;
                    }

                    $data = [
                        'type' => $transport['type'] ?? '',
                        'company' => $transport['company'] ?? '',
                        'seats' => $transport['seats'] ?? 0,
                        'driver_name' => $transport['driver_name'] ?? '',
                        'driver_phone' => $transport['driver_phone'] ?? '',
                        'driver_cccd' => $transport['driver_cccd'] ?? '',
                        'driver_birthdate' => !empty($transport['driver_birthdate']) ? $transport['driver_birthdate'] : null,
                        'license_plate' => $transport['license_plate'] ?? '',
                        // ✅ Thêm 3 dòng này:
                        'pickup_location' => $transport['pickup_location'] ?? '',
                        'pickup_address' => $transport['pickup_address'] ?? '',
                        'pickup_time' => !empty($transport['pickup_time']) ? $transport['pickup_time'] : null
                    ];

                    $this->BookingModel->createTransports($booking_id, $data);
                }
            }

            // 3️⃣ XỬ LÝ ACCOMMODATIONS (KHÁCH SẠN)
            if (isset($_POST['accommodations']) && is_array($_POST['accommodations'])) {
                foreach ($_POST['accommodations'] as $accommodation) {
                    // Bỏ qua nếu không có dữ liệu
                    if (empty($accommodation['name'])) {
                        continue;
                    }

                    $data = [
                        'name' => $accommodation['name'] ?? '',
                        'address' => $accommodation['address'] ?? '',
                        'type' => $accommodation['type'] ?? '',
                        'sdt' => $accommodation['sdt'] ?? ''
                    ];

                    $this->BookingModel->createAccommodations($booking_id, $data);
                }
            }

            // 4️⃣ XỬ LÝ PEOPLE (KHÁCH HÀNG)
            if (isset($_POST['peoples']) && is_array($_POST['peoples'])) {
                $addedCount = 0;
                $errors = [];

                foreach ($_POST['peoples'] as $index => $person) {
                    // ✅ THÊM DEBUG CHI TIẾT
                    error_log("Processing person #{$index}: " . json_encode($person));

                    // Bỏ qua nếu không có dữ liệu
                    if (empty($person['fullname']) && empty($person['existing_id'])) {
                        error_log("⚠️ Skipped person #{$index} - empty fullname and existing_id");
                        continue;
                    }

                    try {
                        // TRƯỜNG HỢP 1: Chọn người có sẵn
                        if (!empty($person['existing_id']) && $person['existing_id'] !== 'new') {
                            error_log("✅ Adding existing person ID: {$person['existing_id']}");
                            $this->BookingModel->addExistingPersonToBooking($booking_id, $person['existing_id']);
                            $addedCount++;
                        }
                        // TRƯỜNG HỢP 2: Thêm người mới
                        else if (!empty($person['fullname'])) {
                            error_log("✅ Creating new person: {$person['fullname']}");
                            $data = [
                                'fullname' => $person['fullname'] ?? '',
                                'phone' => $person['phone'] ?? '',
                                'date' => $person['date'] ?? date('Y-m-d'),
                                'cccd' => $person['cccd'] ?? '',
                                'note' => $person['note'] ?? ''
                            ];

                            $newId = $this->BookingModel->createPeople($booking_id, $data);
                            error_log("✅ Created person ID: $newId");
                            $addedCount++;
                        }
                    } catch (Exception $e) {
                        error_log("❌ Error adding person #{$index}: " . $e->getMessage());
                        $errors[] = "Khách hàng #" . ($index + 1) . ": " . $e->getMessage();

                        // Dừng nếu đầy
                        if (strpos($e->getMessage(), 'đầy') !== false) {
                            break;
                        }
                    }
                }

                if (!empty($errors)) {
                    $_SESSION['warning'] = "Đã thêm $addedCount người. Một số lỗi:\n" . implode("\n", $errors);
                } else {
                    $_SESSION['success'] = "Tạo booking thành công! Đã thêm $addedCount người.";
                }
            }

            // 5️⃣ REDIRECT
            header("Location: index.php?act=bookings&msg=created");
            exit();
        } catch (Exception $e) {
            $_SESSION['error'] = "Lỗi tạo booking: " . $e->getMessage();
            header("Location: index.php?act=booking-add");
            exit;
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
                'end_date' => $_POST['end_date'],
                'max_people' => $_POST['max_people'] ?? 30
            ];
            $this->BookingModel->updateBooking($id, $bookingData);

            // 2. Xử lý TRANSPORTS
            $this->handleTransports($id);

            // 3. Xử lý ACCOMMODATIONS
            $this->handleAccommodations($id);

            // 4. Xử lý PEOPLE
            $this->handlePeople($id);

            $_SESSION['success'] = "Cập nhật booking thành công!";

            // ✅ THAY ĐỔI: Redirect về chính trang edit với thông báo
            header("Location: http://localhost/duan1_n1/index.php?act=bookings-edit&id=" . $id);
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header("Location: index.php?act=booking-edit&id=" . $id . "&error=1");
            exit;
        }
    }

    // ==========================================
    // XỬ LÝ TRANSPORTS
    // ==========================================

    // ==========================================
    // XỬ LÝ TRANSPORTS
    // ==========================================

    private function handleTransports($bookingId)
    {
        // Debug
        error_log("POST transports: " . print_r($_POST['transports'] ?? 'EMPTY', true));

        if (!isset($_POST['transports'])) {
            return;
        }

        $keepIds = [];

        foreach ($_POST['transports'] as $transport) {
            if (empty($transport['type']) && empty($transport['company'])) {
                continue;
            }

            $data = [
                'type' => $transport['type'] ?? '',
                'company' => $transport['company'] ?? '',
                'seats' => $transport['seats'] ?? 0,
                'driver_name' => $transport['driver_name'] ?? '',
                'driver_phone' => $transport['driver_phone'] ?? '',
                'driver_cccd' => $transport['driver_cccd'] ?? '',
                'driver_birthdate' => !empty($transport['driver_birthdate']) ? $transport['driver_birthdate'] : null,
                'license_plate' => $transport['license_plate'] ?? '',
                // ✅ THÊM 3 TRƯỜNG MỚI
                'pickup_location' => $transport['pickup_location'] ?? '',
                'pickup_address' => $transport['pickup_address'] ?? '',
                'pickup_time' => !empty($transport['pickup_time']) ? $transport['pickup_time'] : null
            ];

            if (isset($transport['id']) && !empty($transport['id'])) {
                $keepIds[] = $transport['id'];
                $this->BookingModel->updateTransports($transport['id'], $bookingId, $data);
                error_log("✅ Updated transport ID: {$transport['id']}");
            } else {
                $newId = $this->BookingModel->createTransports($bookingId, $data);
                $keepIds[] = $newId;
            }
        }

        $this->BookingModel->deleteTransports($bookingId, $keepIds);
        error_log("✅ Kept transport IDs: " . implode(', ', $keepIds));
    }

    // ==========================================
    // XỬ LÝ ACCOMMODATIONS
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
                $keepIds[] = $accommodation['id'];
                $this->BookingModel->updateAccommodations($accommodation['id'], $bookingId, $data);
            } else {
                $newId = $this->BookingModel->createAccommodations($bookingId, $data);
                $keepIds[] = $newId;
            }
        }

        $this->BookingModel->deleteAccommodations($bookingId, $keepIds);
    }

    // ==========================================
    // XỬ LÝ PEOPLE - ✅ CẢI TIẾN LOGIC
    // ==========================================

    private function handlePeople($bookingId)
    {
        if (!isset($_POST['peoples'])) {
            return;
        }

        $keepIds = [];
        $errors = [];
        $successCount = 0;

        foreach ($_POST['peoples'] as $index => $person) {
            // Bỏ qua nếu không có dữ liệu
            if (empty($person['fullname']) && empty($person['existing_id'])) {
                continue;
            }

            try {
                // ✅ TRƯỜNG HỢP 1: CHỌN NGƯỜI CÓ SẴN
                if (!empty($person['existing_id']) && $person['existing_id'] !== 'new') {
                    $newId = $this->BookingModel->addExistingPersonToBooking($bookingId, $person['existing_id']);
                    $keepIds[] = $newId;
                    $successCount++;
                }
                // ✅ TRƯỜNG HỢP 2: UPDATE NGƯỜI ĐÃ CÓ TRONG BOOKING
                else if (!empty($person['id']) && is_numeric($person['id'])) {
                    $data = [
                        'fullname' => $person['fullname'] ?? '',
                        'phone' => $person['phone'] ?? '',
                        'date' => $person['date'] ?? date('Y-m-d'),
                        'cccd' => $person['cccd'] ?? '',
                        'note' => $person['note'] ?? ''
                    ];

                    $keepIds[] = $person['id'];
                    $this->BookingModel->updatePeople($person['id'], $bookingId, $data);
                    $successCount++;
                }
                // ✅ TRƯỜNG HỢP 3: THÊM NGƯỜI MỚI
                else if (!empty($person['fullname'])) {
                    $data = [
                        'fullname' => $person['fullname'] ?? '',
                        'phone' => $person['phone'] ?? '',
                        'date' => $person['date'] ?? date('Y-m-d'),
                        'cccd' => $person['cccd'] ?? ''
                    ];

                    $newId = $this->BookingModel->createPeople($bookingId, $data);
                    $keepIds[] = $newId;
                    $successCount++;
                }
            } catch (Exception $e) {
                $errors[] = "Khách hàng #" . ($index + 1) . ": " . $e->getMessage();

                // Dừng nếu đầy
                if (strpos($e->getMessage(), 'đầy') !== false) {
                    break;
                }
            }
        }

        // Xóa những người không còn trong danh sách
        $this->BookingModel->deletePeople($bookingId, $keepIds);

        // Thông báo kết quả
        if (!empty($errors)) {
            $_SESSION['warning'] = "Đã xử lý $successCount người. Một số lỗi:\n" . implode("\n", array_slice($errors, 0, 3));
        } else if ($successCount > 0) {
            $_SESSION['success'] = "Cập nhật thành công! Đã xử lý $successCount người.";
        }
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

    // ==========================================
    // API: LẤY DANH SÁCH NGƯỜI CÓ SẴN
    // ==========================================

    public function getAvailablePeopleApi()
    {
        header('Content-Type: application/json; charset=utf-8');
        ob_clean(); // ✅ XÓA BUFFER CŨ

        try {
            $startDate = $_GET['start_date'] ?? '';
            $endDate = $_GET['end_date'] ?? '';

            if (empty($startDate) || empty($endDate)) {
                echo json_encode(['success' => false, 'message' => 'Missing dates'], JSON_UNESCAPED_UNICODE);
                exit; // ✅ DỪNG NGAY
            }

            $people = $this->BookingModel->getAvailablePeople($startDate, $endDate, null);

            echo json_encode([
                'success' => true,
                'data' => $people,
                'count' => count($people)
            ], JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
        }

        exit; // ✅ QUAN TRỌNG
    }
    // ==========================================
    // API: KIỂM TRA TRÙNG LỊCH
    // ==========================================

    public function checkPersonConflictApi()
    {
        header('Content-Type: application/json; charset=utf-8');

        try {
            $personId = $_GET['person_id'] ?? '';
            $startDate = $_GET['start_date'] ?? '';
            $endDate = $_GET['end_date'] ?? '';
            $bookingId = $_GET['booking_id'] ?? null;

            if (empty($personId) || empty($startDate) || empty($endDate)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Thiếu thông tin'
                ], JSON_UNESCAPED_UNICODE);
                return;
            }

            $conflicts = $this->BookingModel->checkPersonScheduleConflict(
                $personId,
                $startDate,
                $endDate,
                $bookingId
            );

            echo json_encode([
                'success' => true,
                'has_conflict' => !empty($conflicts),
                'conflicts' => $conflicts
            ], JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
        exit;
    }
    // ==========================================
    // API: KIỂM TRA TRÙNG LỊCH HƯỚNG DẪN VIÊN
    // ==========================================

    public function checkGuideConflictApi()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');

        try {
            $guideId = $_GET['guide_id'] ?? '';
            $startDate = $_GET['start_date'] ?? '';
            $endDate = $_GET['end_date'] ?? '';
            $bookingId = $_GET['booking_id'] ?? null;

            if (empty($guideId) || empty($startDate) || empty($endDate)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Thiếu thông tin'
                ], JSON_UNESCAPED_UNICODE);
                exit;
            }

            $conflicts = $this->BookingModel->checkGuideScheduleConflict(
                $guideId,
                $startDate,
                $endDate,
                $bookingId
            );

            echo json_encode([
                'success' => true,
                'has_conflict' => !empty($conflicts),
                'conflicts' => $conflicts
            ], JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
        exit;
    }

    // ==========================================
    // API: LẤY DANH SÁCH HDV CÓ SẴN
    // ==========================================

    public function getAvailableGuidesApi()
    {
        header('Content-Type: application/json; charset=utf-8');
        ob_clean(); // ✅ XÓA BUFFER CŨ

        try {
            $startDate = $_GET['start_date'] ?? '';
            $endDate = $_GET['end_date'] ?? '';

            if (empty($startDate) || empty($endDate)) {
                echo json_encode(['success' => false, 'message' => 'Missing dates'], JSON_UNESCAPED_UNICODE);
                exit;
            }

            $guides = $this->BookingModel->getAvailableGuides($startDate, $endDate, null);

            echo json_encode([
                'success' => true,
                'data' => $guides,
                'count' => count($guides)
            ], JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
        }

        exit; // ✅ QUAN TRỌNG
    }
}
