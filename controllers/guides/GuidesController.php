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
    $user_id = $_SESSION['user']['id'] ?? null;
    $selected_date = $_GET['date'] ?? date('Y-m-d');

    if (!$booking_id || !$user_id) {
        die('Thiếu thông tin');
    }

    // Lấy thông tin booking
    $booking = $this->GuidesModel->getBookingById($booking_id);

    // Xử lý JSON nếu cần
    if (isset($booking['guide']) && is_string($booking['guide'])) {
        $booking['guide'] = json_decode($booking['guide'], true);
    }
    if (isset($booking['tour']) && is_string($booking['tour'])) {
        $booking['tour'] = json_decode($booking['tour'], true);
    }

    // Kiểm tra quyền sở hữu tour
    if (!$booking || ($booking['guide']['user_id'] ?? 0) != $user_id) {
        die('Bạn không có quyền truy cập tour này!');
    }

    // Lấy danh sách khách
    $dataPeople = $this->GuidesModel->booking_people($booking_id);

    // Lấy danh sách ngày điểm danh
    $validDates = $this->GuidesModel->getAttendanceDates($booking_id);

    // Nếu không có (lỗi DB), tạo từ start_date → end_date
    if (empty($validDates)) {
        $start = new DateTime($booking['start_date']);
        $end   = new DateTime($booking['end_date']);
        $end->modify('+1 day');
        $period = new DatePeriod($start, new DateInterval('P1D'), $end);
        foreach ($period as $d) {
            $validDates[] = ['date' => $d->format('Y-m-d')];
        }
    }

    // Đảm bảo ngày chọn hợp lệ
    $validDateValues = array_column($validDates, 'date');
    if (!in_array($selected_date, $validDateValues)) {
        $selected_date = date('Y-m-d');
        if (in_array($selected_date, $validDateValues)) {
            // OK
        } else if (!empty($validDateValues)) {
            $selected_date = $validDateValues[0]; // chọn ngày đầu tiên
        }
    }

    // Lấy dữ liệu điểm danh của ngày đã chọn
    $attendance_data = $this->GuidesModel->getAttendanceHistory($booking_id, $selected_date);
    $att_map = [];
    foreach ($attendance_data as $row) {
        $att_map[$row['id']] = $row;
    }

    $today = date('Y-m-d');
    $is_today = ($selected_date === $today);

    // Truyền tất cả biến cần thiết vào view
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
        $user_id    = $_SESSION['user']['id'] ?? null;

        if (!$booking_id || !$date || !$user_id) {
            die('Thiếu dữ liệu');
        }

        // Kiểm tra quyền - DÙNG user_id CHỨ KHÔNG PHẢI user['id']
        $booking = $this->GuidesModel->getBookingById($booking_id);


        // Đảm bảo guide luôn là array
if (isset($booking['guide']) && is_string($booking['guide'])) {
    $booking['guide'] = json_decode($booking['guide'], true);
}
// Nếu vẫn là null hoặc không có → lấy từ DB (an toàn tuyệt đối)
if (empty($booking['guide']['user_id'])) {
    $guideStmt = $this->conn->prepare("SELECT user_id FROM guides WHERE id = ?");
    $guideStmt->execute([$booking['guide_id'] ?? 0]);
    $guideRow = $guideStmt->fetch(PDO::FETCH_ASSOC);
    $booking['guide']['user_id'] = $guideRow['user_id'] ?? 0;
}

        if (!$booking || ($booking['guide']['user_id'] ?? 0) != $user_id) {
            die('Bạn không có quyền lưu điểm danh tour này!');
        }

        // Kiểm tra chỉ được điểm danh hôm nay
        if ($date !== date('Y-m-d')) {
            echo "<script>alert('Chỉ được điểm danh vào hôm nay!'); history.back();</script>";
            exit;
        }

        $pdo = connectDB();
        $pdo->beginTransaction();

        try {
            $sql = "INSERT INTO attendances 
                    (booking_people_id, attendance_date, status, note, created_at, updated_at) 
                    VALUES (?, ?, ?, ?, NOW(), NOW())
                    ON DUPLICATE KEY UPDATE 
                    status = VALUES(status),
                    note = VALUES(note),
                    updated_at = NOW()";

            $stmt = $pdo->prepare($sql);

            foreach ($_POST['attendance'] ?? [] as $people_id => $val) {
                $status = $val == '1' ? 'present' : 'absent';
                $note   = $_POST['notes'][$people_id] ?? '';

                $stmt->execute([$people_id, $date, $status, $note]);
            }

            // Đánh dấu vắng những người không được tick
            $absent_sql = "INSERT IGNORE INTO attendances 
                          (booking_people_id, attendance_date, status, note, created_at, updated_at)
                          SELECT bp.id, ?, 'absent', '', NOW(), NOW()
                          FROM bookings_people bp
                          WHERE bp.booking_id = ? 
                          AND bp.id NOT IN (SELECT booking_people_id FROM attendances WHERE attendance_date = ?)";
            $stmt_absent = $pdo->prepare($absent_sql);
            $stmt_absent->execute([$date, $booking_id, $date]);

            $pdo->commit();
            echo "<script>
                alert('Điểm danh thành công!');
                window.location.href = 'index.php?act=job-guide&id=" . htmlspecialchars($booking_id, ENT_QUOTES) . "';
              </script>";
        exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            echo "<script>alert('Lỗi: " . addslashes($e->getMessage()) . "'); history.back();</script>";
        }
    }
    //aaaa
}