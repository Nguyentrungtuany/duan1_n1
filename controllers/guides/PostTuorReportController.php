<?php

class PostTuorReportController
{
    private $model;

    public function __construct()
    {
        $this->model = new PostTourReportModel();
    }

    /**
     * Hiển thị form báo cáo
     */
    public function index()
    {
        // ✅ Nhận booking_id từ URL
        $booking_id = $_GET['booking_id'] ?? null;

        if (!$booking_id) {
            $_SESSION['error'] = "Lỗi: Không tìm thấy booking_id!";
            header('Location: ?act=job-guide');
            exit;
        }

        // Lấy thông tin guide từ session
        $guide_id = $_SESSION['user']['id'] ?? null;

        if (!$guide_id) {
            $_SESSION['error'] = "Vui lòng đăng nhập!";
            header('Location: ?act=login');
            exit;
        }

        // Kiểm tra guide có được phân công booking này không
        $booking = $this->model->getAssignedBookingForGuide($booking_id, $guide_id);

        if (!$booking) {
            $_SESSION['error'] = "Bạn không được phân công tour này hoặc chưa có dữ liệu phân công!";
            header('Location: ?act=job-guide');
            exit;
        }

        // Kiểm tra đã báo cáo chưa
        $reported = $this->model->hasReport($booking_id);

        // Hiển thị form
        require_once 'views/guides/report_form.php';
    }

    /**
     * Xử lý submit báo cáo
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?act=job-guide');
            exit;
        }

        $booking_id = $_POST['booking_id'] ?? null;
        $guide_id = $_SESSION['user']['id'] ?? null;

        if (!$booking_id || !$guide_id) {
            $_SESSION['error'] = "Thiếu thông tin!";
            header('Location: ?act=job-guide');
            exit;
        }

        // Kiểm tra quyền
        $booking = $this->model->getAssignedBookingForGuide($booking_id, $guide_id);
        if (!$booking) {
            $_SESSION['error'] = "Không có quyền báo cáo!";
            header('Location: ?act=job-guide');
            exit;
        }

        // Kiểm tra đã báo cáo
        if ($this->model->hasReport($booking_id)) {
            $_SESSION['error'] = "Bạn đã gửi báo cáo rồi!";
            header("Location: ?act=bao-cao-booking&booking_id=$booking_id");
            exit;
        }

        // Xử lý upload ảnh
        $uploadedImages = [];
        if (!empty($_FILES['images']['name'][0])) {
            $uploadDir = 'uploads/reports/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $maxFiles = 10;
            $count = min(count($_FILES['images']['name']), $maxFiles);

            for ($i = 0; $i < $count; $i++) {
                if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                    $tmpName = $_FILES['images']['tmp_name'][$i];
                    $fileName = time() . '_' . uniqid() . '_' . basename($_FILES['images']['name'][$i]);
                    $targetPath = $uploadDir . $fileName;

                    if (move_uploaded_file($tmpName, $targetPath)) {
                        $uploadedImages[] = $targetPath;
                    }
                }
            }
        }

        // Lưu báo cáo
        $data = [
            'booking_id'         => $booking_id,
            'guide_id'           => $guide_id,
            'tour_summary'       => $_POST['tour_summary'] ?? '',
            'customer_situation' => $_POST['customer_situation'] ?? '',
            'incidents'          => $_POST['incidents'] ?? '',
            'suggestions'        => $_POST['suggestions'] ?? '',
            'images'             => $uploadedImages
        ];

        try {
            $this->model->createReport($data);
            $_SESSION['success'] = "Gửi báo cáo thành công!";
            header('Location: ?act=bao-cao-booking&booking_id=' . $booking_id);
        } catch (Exception $e) {
            $_SESSION['error'] = "Lỗi: " . $e->getMessage();
            header("Location: ?act=bao-cao-booking&booking_id=$booking_id");
        }
        exit;
    }
}