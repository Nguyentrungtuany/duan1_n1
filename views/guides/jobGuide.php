<?php
require_once 'views/layout/guides/header.php';

foreach ($data as &$item) {
    $item['destination']      = !empty($item['destination'])      ? json_decode($item['destination'], true)      : [];
    $item['transports']       = !empty($item['transports'])       ? json_decode($item['transports'], true)       : [];
    $item['accommodations']   = !empty($item['accommodations'])   ? json_decode($item['accommodations'], true)   : [];
    $item['schedules']        = !empty($item['schedules'])        ? json_decode($item['schedules'], true)        : [];
    $item['tour']             = !empty($item['tour'])             ? json_decode($item['tour'], true)             : [];
    $item['customer']         = !empty($item['customer'])         ? json_decode($item['customer'], true)         : [];
    $item['people']           = !empty($item['people'])           ? json_decode($item['people'], true)           : [];
    $item['user']             = !empty($item['user'])             ? json_decode($item['user'], true)             : [];
    $item['guide']            = !empty($item['guide'])            ? json_decode($item['guide'], true)            : [];
    $item['category']         = !empty($item['category'])         ? json_decode($item['category'], true)         : [];
}
?>

<style>
    .info-group {
        margin-bottom: 15px;
    }

    .info-group label {
        font-weight: bold;
        color: #555;
        margin-bottom: 5px;
        display: block;
    }

    .info-group p {
        margin: 0;
        color: #333;
    }

    .transport-card,
    .accommodation-card,
    .schedule-card {
        background: #f9f9f9;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 15px;
        border: 1px solid #e0e0e0;
    }

    .schedule-header {
        border-bottom: 2px solid #5cb85c;
        margin-bottom: 15px;
        padding-bottom: 10px;
    }

    .stats-box {
        background: white;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }

    .stats-box:hover {
        transform: translateY(-5px);
    }

    .stats-box h3 {
        margin: 0;
        font-size: 32px;
        font-weight: bold;
    }

    .stats-box p {
        margin: 5px 0 0 0;
        color: #666;
    }

    .filter-buttons {
        background: white;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .filter-btn {
        margin-right: 10px;
        margin-bottom: 10px;
    }

    .booking-item {
        background: white;
        margin-bottom: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: all 0.3s;
    }

    .booking-item:hover {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .booking-summary {
        padding: 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .booking-summary h3 {
        margin: 0 0 10px 0;
        color: white;
        font-size: 20px;
    }

    .quick-info {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 10px;
    }

    .quick-info span {
        background: rgba(255, 255, 255, 0.2);
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 13px;
    }

    .booking-general-info {
        padding: 20px;
        background: white;
    }

    .booking-details {
        padding: 20px;
        display: none;
        background: #f9f9f9;
    }

    .booking-details.show {
        display: block;
    }

    .panel {
        margin-bottom: 20px;
    }

    .panel-heading h4 {
        margin: 0;
        font-size: 16px;
    }

    .label {
        font-size: 12px;
        padding: 5px 10px;
    }

    .action-buttons {
        margin-top: 15px;
    }
</style>

<div id="page-wrapper">
    <div class="main-page">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title1">Công Việc Của Tôi</h2>
                <p class="text-muted">Quản lý và theo dõi các tour được phân công</p>
            </div>
        </div>

        <!-- Statistics -->
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-3">
                <div class="stats-box">
                    <i class="fa fa-calendar fa-3x text-primary pull-right"></i>
                    <h3><?php echo $job_status['total_records']; ?></h3>
                    <p>Tổng công việc</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-box">
                    <i class="fa fa-clock-o fa-3x text-warning pull-right"></i>
                    <h3 class="text-warning"><?php echo $job_status['total_unpaid']; ?></h3>
                    <p>Chưa thanh toán</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-box">
                    <i class="fa fa-check-circle fa-3x text-info pull-right"></i>
                    <h3 class="text-info"><?php echo $job_status['total_paid']; ?></h3>
                    <p>Đã thanh toán</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-box">
                    <i class="fa fa-check-square fa-3x text-success pull-right"></i>
                    <h3 class="text-success"><?php echo $job_status['total_completed']; ?></h3>
                    <p>Hoàn thành</p>
                </div>
            </div>
        </div>

        <!-- Filter Buttons -->
        <div class="filter-buttons">
            <button class="btn btn-primary filter-btn active" data-filter="all">
                <i class="fa fa-list"></i> Tất cả (<?php echo $job_status['total_records']; ?>)
            </button>
            <button class="btn btn-warning filter-btn" data-filter="pending">
                <i class="fa fa-clock-o"></i> Chờ xác nhận
            </button>
            <button class="btn btn-info filter-btn" data-filter="confirmed">
                <i class="fa fa-check-circle"></i> Đã xác nhận
            </button>
            <button class="btn btn-success filter-btn" data-filter="completed">
                <i class="fa fa-check-square"></i> Hoàn thành
            </button>
        </div>

        <!-- DANH SÁCH BOOKINGS -->
        <?php if (empty($data)): ?>
            <div class="alert alert-info text-center">
                <i class="fa fa-inbox fa-3x"></i>
                <h4>Không có công việc nào</h4>
            </div>
        <?php else: ?>
            <?php foreach ($data as $booking): ?>
                <div class="booking-item" data-status="<?= $booking['status'] ?>">
                    <!-- HEADER -->
                    <div class="booking-summary">
                        <div class="row">
                            <div class="col-md-8">
                                <h3>
                                    <i class="fa fa-map-signs"></i>
                                    <?= htmlspecialchars($booking['tour']['name'] ?? 'Tour chưa có tên') ?>
                                </h3>
                                <div class="quick-info">
                                    <span><i class="fa fa-map-marker"></i> <?= htmlspecialchars($booking['destination']['name'] ?? 'N/A') ?></span>
                                    <span><i class="fa fa-calendar"></i> <?= date('d/m/Y', strtotime($booking['start_date'])) ?> - <?= date('d/m/Y', strtotime($booking['end_date'])) ?></span>
                                    <span><i class="fa fa-users"></i> <?= $booking['number_of_people'] ?? 0 ?> người</span>
                                </div>
                            </div>
                            <div class="col-md-4 text-right">
                                <h2 style="margin: 0 0 10px 0; color: white;">
                                    <?= number_format(($booking['tour']['price'] ?? 0) * ($booking['number_of_people'] ?? 0), 0, ',', '.') ?> VNĐ
                                </h2>
                                <?php
                                $statusClass = [
                                    'pending' => 'label-warning',
                                    'confirmed' => 'label-info',
                                    'completed' => 'label-success',
                                    'cancelled' => 'label-danger'
                                ];
                                $statusText = [
                                    'pending' => 'Chờ xác nhận',
                                    'confirmed' => 'Đã xác nhận',
                                    'completed' => 'Hoàn thành',
                                    'cancelled' => 'Đã hủy'
                                ];
                                ?>
                                <span class="label <?= $statusClass[$booking['status']] ?? 'label-default' ?>" style="font-size: 13px; padding: 6px 12px;">
                                    <?= $statusText[$booking['status']] ?? $booking['status'] ?>
                                </span>
                                <span class="label <?= $booking['payment_status'] == 'paid' ? 'label-success' : 'label-danger' ?>" style="font-size: 13px; padding: 6px 12px;">
                                    <?= $booking['payment_status'] == 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- THÔNG TIN CHUNG -->
                    <div class="booking-general-info">
                        <h4 style="margin-top: 0; margin-bottom: 15px;"><i class="fa fa-info-circle"></i> Thông tin chung</h4>
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="info-group">
                                    <label>Mã Booking:</label>
                                    <p><strong>#<?= htmlspecialchars($booking['id']) ?></strong></p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="info-group">
                                    <label>Số lượng người:</label>
                                    <p><strong><?= htmlspecialchars($booking['number_of_people'] ?? 0) ?> người</strong></p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="info-group">
                                    <label>Ngày tạo:</label>
                                    <p><?= date('d/m/Y', strtotime($booking['created_at'])) ?></p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="info-group">
                                    <label>Cập nhật:</label>
                                    <p><?= date('d/m/Y', strtotime($booking['updated_at'])) ?></p>
                                </div>
                            </div>
                        </div>

                        <?php if (!empty($booking['special_request'])): ?>
                            <div class="alert alert-warning" style="margin-top: 15px; margin-bottom: 0;">
                                <strong><i class="fa fa-exclamation-triangle"></i> Yêu cầu đặc biệt:</strong><br>
                                <?= htmlspecialchars($booking['special_request']) ?>
                            </div>
                        <?php endif; ?>

                        <!-- CÁC NÚT HÀNH ĐỘNG -->
                        <div class="row action-buttons">
                            <div class="col-md-4 col-sm-4 col-xs-12" style="margin-bottom: 10px;">
                                <button class="btn btn-primary btn-block btn-lg" onclick="toggleDetails(<?= $booking['id'] ?>)">
                                    <i class="fa fa-angle-down"></i> Xem thêm
                                </button>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12" style="margin-bottom: 10px;">
                                <a href="index.php?act=rollcall_Guide&id=<?= $booking['id'] ?>" class="btn btn-success btn-block btn-lg">
                                    <i class="fa fa-check-square-o"></i> Điểm danh
                                </a>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12" style="margin-bottom: 10px;">
    <a href="index.php?act=bao-cao-booking&booking_id=<?= $booking['id'] ?>" 
       class="btn btn-warning btn-block btn-lg">
        <i class="fa fa-file-text-o"></i> Báo cáo
    </a>
</div>
                        </div>
                    </div>

                    <!-- CHI TIẾT ĐẦY ĐỦ (Ẩn mặc định) -->
                    <div class="booking-details" id="details-<?= $booking['id'] ?>">
                        <div class="row">
                            <!-- TOUR & ĐIỂM ĐẾN -->
                            <div class="col-md-6">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h4><i class="fa fa-suitcase"></i> Thông tin Tour</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="info-group">
                                            <label>Tên Tour:</label>
                                            <p><strong><?= htmlspecialchars($booking['tour']['name'] ?? 'Chưa có tên tour') ?></strong></p>
                                        </div>
                                        <div class="info-group">
                                            <label>Danh mục:</label>
                                            <p><?= htmlspecialchars($booking['category']['name'] ?? 'Chưa phân loại') ?></p>
                                        </div>
                                        <div class="info-group">
                                            <label>Giá tour:</label>
                                            <p><strong style="font-size: 18px; color: #d9534f;">
                                                    <?= number_format($booking['tour']['price'] ?? 0, 0, ',', '.') ?> VNĐ
                                                </strong></p>
                                        </div>
                                        <div class="info-group">
                                            <label>Tổng tiền:</label>
                                            <p><strong style="font-size: 20px; color: #5cb85c;">
                                                    <?= number_format(($booking['tour']['price'] ?? 0) * ($booking['number_of_people'] ?? 0), 0, ',', '.') ?> VNĐ
                                                </strong></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <h4><i class="fa fa-map-marker"></i> Điểm đến</h4>
                                    </div>
                                    <div class="panel-body">
                                        <?php if (!empty($booking['destination'])): ?>
                                            <div class="info-group">
                                                <label>Tên điểm đến:</label>
                                                <p><strong><?= htmlspecialchars($booking['destination']['name'] ?? 'Không có tên') ?></strong></p>
                                            </div>
                                            <div class="info-group">
                                                <label>Địa điểm:</label>
                                                <p><?= htmlspecialchars($booking['destination']['location'] ?? 'Không có địa điểm') ?></p>
                                            </div>
                                        <?php else: ?>
                                            <p class="text-muted">Chưa có thông tin điểm đến</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- KHÁCH HÀNG & HƯỚNG DẪN VIÊN -->
                            <div class="col-md-6">
                                <div class="panel panel-warning">
                                    <div class="panel-heading">
                                        <h4><i class="fa fa-user"></i> Thông tin khách hàng</h4>
                                    </div>
                                    <div class="panel-body">
                                        <?php if (!empty($booking['customer'])): ?>
                                            <div class="info-group">
                                                <label>Họ và tên:</label>
                                                <p><strong><?= htmlspecialchars($booking['customer']['full_name'] ?? 'Chưa có tên') ?></strong></p>
                                            </div>
                                            <div class="info-group">
                                                <label>Email:</label>
                                                <p><i class="fa fa-envelope"></i> <?= htmlspecialchars($booking['customer']['email'] ?? 'Chưa có email') ?></p>
                                            </div>
                                            <div class="info-group">
                                                <label>Số điện thoại:</label>
                                                <p><i class="fa fa-phone"></i> <?= htmlspecialchars($booking['customer']['phone'] ?? 'Chưa có SĐT') ?></p>
                                            </div>
                                            <div class="info-group">
                                                <label>Địa chỉ:</label>
                                                <p><?= htmlspecialchars($booking['customer']['address'] ?? 'Chưa có địa chỉ') ?></p>
                                            </div>
                                        <?php else: ?>
                                            <p class="text-muted">Chưa có thông tin khách hàng</p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h4><i class="fa fa-user-circle"></i> Hướng dẫn viên</h4>
                                    </div>
                                    <div class="panel-body">
                                        <?php if (!empty($booking['guide'])): ?>
                                            <div class="info-group">
                                                <label>Họ và tên:</label>
                                                <p><strong><?= htmlspecialchars($booking['guide']['full_name'] ?? 'Chưa có tên') ?></strong></p>
                                            </div>
                                            <div class="info-group">
                                                <label>Chuyên môn:</label>
                                                <p><?= htmlspecialchars($booking['guide']['specialization'] ?? 'Chưa có') ?></p>
                                            </div>
                                            <div class="info-group">
                                                <label>Kinh nghiệm:</label>
                                                <p><strong><?= htmlspecialchars($booking['guide']['experience_years'] ?? 0) ?> năm</strong></p>
                                            </div>
                                        <?php else: ?>
                                            <p class="text-muted">Chưa có thông tin hướng dẫn viên</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PHƯƠNG TIỆN & CHỖ Ở -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4><i class="fa fa-bus"></i> Phương tiện di chuyển</h4>
                                    </div>
                                    <div class="panel-body">
                                        <?php if (!empty($booking['transports'])): ?>
                                            <?php foreach ($booking['transports'] as $index => $transport): ?>
                                                <div class="transport-card">
                                                    <h5><strong>Phương tiện <?= $index + 1 ?></strong></h5>
                                                    <p><strong>Loại:</strong> <?= htmlspecialchars($transport['type']) ?></p>
                                                    <p><strong>Số chỗ:</strong> <?= $transport['seats'] ?> chỗ</p>
                                                    <?php if (!empty($transport['company'])): ?>
                                                        <p><strong>Công ty:</strong> <?= htmlspecialchars($transport['company']) ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <p class="text-muted">Chưa có thông tin phương tiện</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <h4><i class="fa fa-hotel"></i> Chỗ ở</h4>
                                    </div>
                                    <div class="panel-body">
                                        <?php if (!empty($booking['accommodations'])): ?>
                                            <?php foreach ($booking['accommodations'] as $index => $accommodation): ?>
                                                <div class="accommodation-card">
                                                    <h5><strong>Khách sạn <?= $index + 1 ?></strong></h5>
                                                    <p><strong><?= htmlspecialchars($accommodation['name']) ?></strong></p>
                                                    <p><?= htmlspecialchars($accommodation['type']) ?></p>
                                                    <p><?= htmlspecialchars($accommodation['address']) ?></p>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <p class="text-muted">Chưa có thông tin chỗ ở</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- LỊCH TRÌNH -->
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h4><i class="fa fa-calendar"></i> Lịch trình chi tiết</h4>
                            </div>
                            <div class="panel-body">
                                <?php if (!empty($booking['schedules'])): ?>
                                    <?php foreach ($booking['schedules'] as $schedule): ?>
                                        <div class="schedule-card">
                                            <div class="schedule-header">
                                                <h4>
                                                    <span class="label label-success">Ngày <?= $schedule['day_number'] ?></span>
                                                    <span style="margin-left: 15px; color: #666;"><?= date('d/m/Y', strtotime($schedule['date'])) ?></span>
                                                </h4>
                                            </div>
                                            <p><strong>Địa điểm:</strong> <?= htmlspecialchars($schedule['location']) ?></p>
                                            <p><strong>Hoạt động:</strong> <?= nl2br(htmlspecialchars($schedule['activities'])) ?></p>
                                            <?php if (!empty($schedule['notes'])): ?>
                                                <p style="color: #d9534f;"><strong>Ghi chú:</strong> <?= htmlspecialchars($schedule['notes']) ?></p>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-muted">Chưa có lịch trình</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- DANH SÁCH NGƯỜI THAM GIA -->
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <h4><i class="fa fa-users"></i> Danh sách người tham gia</h4>
                            </div>
                            <div class="panel-body">
                                <?php if (!empty($booking['people'])): ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Họ và tên</th>
                                                    <th>Ngày</th>
                                                    <th>Số điện thoại</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($booking['people'] as $index => $person): ?>
                                                    <tr>
                                                        <td><?= $index + 1 ?></td>
                                                        <td><strong><?= htmlspecialchars($person['fullname']) ?></strong></td>
                                                        <td><?= htmlspecialchars($person['date']) ?></td>
                                                        <td><?= htmlspecialchars($person['phone']) ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted">Chưa có danh sách người tham gia</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- NÚT THU GỌN -->
                        <div class="row action-buttons">
                            <div class="col-md-4 col-sm-4 col-xs-12" style="margin-bottom: 10px;">
                                <button class="btn btn-default btn-block btn-lg" onclick="toggleDetails(<?= $booking['id'] ?>)">
                                    <i class="fa fa-angle-up"></i> Thu gọn
                                </button>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12" style="margin-bottom: 10px;">
                                <a href="index.php?act=rollcall_Guide&id=<?= $booking['id'] ?>" class="btn btn-success btn-block btn-lg">
                                    <i class="fa fa-check-square-o"></i> Điểm danh
                                </a>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12" style="margin-bottom: 10px;">
                                <a href="?act=bao-cao-booking&booking_id=<?= $booking['id'] ?>" class="btn btn-warning btn-block btn-lg">
                                    <i class="fa fa-file-text-o"></i> Báo cáo
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
    function toggleDetails(bookingId) {
        const detailsDiv = document.getElementById('details-' + bookingId);
        detailsDiv.classList.toggle('show');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.filter-btn');

        filterButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const filter = this.dataset.filter;

                filterButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                document.querySelectorAll('.booking-item').forEach(item => {
                    if (filter === 'all' || item.dataset.status === filter) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    });
</script>

<?php
require_once 'views/layout/guides/footer.php';
?>