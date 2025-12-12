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
        $user_id = $_SESSION['user']['id'] ?? null;
        if (!$user_id) {
            header('Location: index.php?act=login');
            exit;
        }

        // THÊM DÒNG NÀY: Truyền biến $user vào view
        $user = $_SESSION['user'];

        require_once './views/guides/indexGuide.php';
    }

    public function detail()
    {
        $user_id = $_SESSION['user']['id'] ?? null;
        if (!$user_id) {
            header('Location: index.php?act=login');
            exit;
        }

        $data = $this->GuidesModel->jobinformation($user_id);
        $job_status = $this->GuidesModel->jobStatus($user_id);
        require_once './views/guides/jobGuide.php';
    }

    public function rollcall()
{
    $booking_id = $_GET['id'] ?? null;
    $user_id    = $_SESSION['user']['id'] ?? null;
    $selected_date = $_GET['date'] ?? date('Y-m-d'); // mặc định hôm nay
    $selected_session = $_GET['session'] ?? 'morning';

    if (!$booking_id || !$user_id) {
        die('Thiếu thông tin booking hoặc người dùng.');
    }

    // === 1. Lấy thông tin booking ===
    $booking = $this->GuidesModel->getBookingById($booking_id);

    // Decode JSON fields
    foreach (['tour', 'guide', 'category', 'destination', 'transports', 'people', 'schedules', 'accommodations'] as $field) {
        if (isset($booking[$field]) && is_string($booking[$field])) {
            $booking[$field] = json_decode($booking[$field], true);
        }
    }

    // === 2. Kiểm tra quyền sở hữu booking (an toàn tuyệt đối) ===
    $stmt = $this->conn->prepare("SELECT g.user_id FROM bookings b JOIN guides g ON b.guide_id = g.id WHERE b.id = ?");
    $stmt->execute([$booking_id]);
    $guide_row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$guide_row || $guide_row['user_id'] != $user_id) {
        die('Bạn không có quyền truy cập booking này!');
    }

    // === 3. Lấy danh sách người và ngày hợp lệ ===
    $people = $this->GuidesModel->booking_people($booking_id);
    $validDates = $this->GuidesModel->getAttendanceDates($booking_id); // mảng ['date' => '2025-12-06', ...]

    if (empty($validDates)) {
        die('Không tìm thấy ngày điểm danh cho tour này.');
    }

    $validDateValues = array_column($validDates, 'date');

    // === 4. Xử lý ngày chọn: luôn fallback về ngày hợp lệ trong tour ===
    if (!in_array($selected_date, $validDateValues)) {
        $selected_date = $validDateValues[0]; // chọn ngày đầu tiên của tour
    }

    // === 5. Xử lý buổi chọn ===
    $allowed_sessions = ['morning', 'afternoon', 'evening'];
    if (!in_array($selected_session, $allowed_sessions)) {
        $selected_session = 'morning';
    }

    // === 6. Lấy dữ liệu điểm danh theo ngày + buổi ===
    $attendance_data = $this->GuidesModel->getAttendanceHistory($booking_id, $selected_date, $selected_session);

    $att_map = [];
    foreach ($attendance_data as $row) {
        $att_map[$row['id']] = $row;
    }

    // === 7. Xác định quyền chỉnh sửa ===
    $today = date('Y-m-d');
    $can_edit = ($selected_date === $today); // Chỉ hôm nay mới được chỉnh sửa

    // === 8. Truyền dữ liệu vào view ===
    require_once './views/guides/rollcall_Guide.php';
}
    public function saveDiemDanh()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: index.php?act=job-guide');
        exit;
    }

    $booking_id = $_POST['booking_id'] ?? null;
    $date       = $_POST['attendance_date'] ?? null;
    $session    = $_POST['session'] ?? 'morning';
    $user_id    = $_SESSION['user']['id'] ?? null;

    if (!$booking_id || !$date || !$user_id) {
        echo "<script>alert('Thiếu dữ liệu!'); history.back();</script>";
        exit;
    }

    

    // Kiểm tra quyền
    $booking = $this->GuidesModel->getBookingById($booking_id);
    if (isset($booking['guide']) && is_string($booking['guide'])) {
        $booking['guide'] = json_decode($booking['guide'], true);
    }

    if (!$booking || ($booking['guide']['user_id'] ?? 0) != $user_id) {
        echo "<script>alert('Bạn không có quyền!'); history.back();</script>";
        exit;
    }

    // Chuẩn bị data theo định dạng model yêu cầu
    $people = $this->GuidesModel->booking_people($booking_id);
    $data = [
        'people' => $people,
        'attendance' => $_POST['attendance'] ?? [],
        'notes' => $_POST['notes'] ?? []
    ];

    // Gọi hàm có sẵn trong model (đã có kiểm tra ngày hôm nay + ngày hợp lệ)
    $result = $this->GuidesModel->saveAttendance($booking_id, $date, $session, $data);

$session = $_POST['session'] ?? 'morning';
if (!in_array($session, ['morning', 'afternoon', 'evening'])) {
    $session = 'morning';
}

$data = [
    'people' => $people,
    'attendance' => $_POST['attendance'] ?? [],
    'notes' => $_POST['notes'] ?? []
];

$result = $this->GuidesModel->saveAttendance($booking_id, $date, $session, $data);

    if ($result['success']) {
        echo "<script>
            alert('{$result['message']}');
            window.location.href = 'index.php?act=rollcall_Guide&id={$booking_id}&date={$date}';
        </script>";
    } else {
        echo "<script>
            alert('{$result['message']}');
            history.back();
        </script>";
    }
    exit;
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
    //aaaa
}
