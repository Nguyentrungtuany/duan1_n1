<?php
require_once 'views/layout/guides/header.php';
// print_r($data);
foreach ($data as &$item) {
    $item['destination']      = !empty($item['destination'])      ? json_decode($item['destination'], true)      : [];
    $item['destinations']      = !empty($item['destinations'])      ? json_decode($item['destinations'], true)      : [];
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
                    <h3 class="text-warning"><?php echo $job_status['pending']; ?></h3>
                    <p>Tuor chưa đi</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-box">
                    <i class="fa fa-check-circle fa-3x text-info pull-right"></i>
                    <h3 class="text-info"><?php echo $job_status['confirmed']; ?></h3>
                    <p>Tuor đang đi</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-box">
                    <i class="fa fa-check-square fa-3x text-success pull-right"></i>
                    <h3 class="text-success"><?php echo $job_status['completed']; ?></h3>
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
                                <!-- <span class="label <?= $booking['payment_status'] == 'paid' ? 'label-success' : 'label-danger' ?>" style="font-size: 13px; padding: 6px 12px;">
                                    <?= $booking['payment_status'] == 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' ?>
                                </span> -->
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
                                    <!-- <div class="panel-heading">
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
                                    </div> -->
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
                                                <div style="border: 1px solid #ddd; padding: 12px; margin-bottom: 12px; border-radius: 5px; background: #f9f9f9;">
                                                    <h5 style="color: #337ab7; margin-top: 0; margin-bottom: 12px; font-size: 15px;">
                                                        <i class="fa fa-car"></i> Phương tiện #<?= $index + 1 ?>
                                                    </h5>

                                                    <!-- Thông tin cơ bản -->
                                                    <div class="info-group">
                                                        <label style="font-size: 12px; color: #555; margin-bottom: 3px;">
                                                            <i class="fa fa-tag"></i> Loại xe:
                                                        </label>
                                                        <p style="margin: 0 0 8px 0; font-weight: 500;">
                                                            <?= htmlspecialchars($transport['type'] ?? 'Chưa cập nhật') ?>
                                                        </p>
                                                    </div>

                                                    <div class="row" style="margin-bottom: 8px;">
                                                        <div class="col-xs-6">
                                                            <div class="info-group">
                                                                <label style="font-size: 12px; color: #555; margin-bottom: 3px;">
                                                                    <i class="fa fa-users"></i> Số chỗ:
                                                                </label>
                                                                <p style="margin: 0; font-weight: 500;">
                                                                    <?= htmlspecialchars($transport['seats'] ?? 'N/A') ?> chỗ
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <div class="info-group">
                                                                <label style="font-size: 12px; color: #555; margin-bottom: 3px;">
                                                                    <i class="fa fa-car"></i> Biển số:
                                                                </label>
                                                                <p style="margin: 0; font-weight: 500;">
                                                                    <?= htmlspecialchars($transport['license_plate'] ?? 'N/A') ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <?php if (!empty($transport['company'])): ?>
                                                        <div class="info-group" style="margin-bottom: 8px;">
                                                            <label style="font-size: 12px; color: #555; margin-bottom: 3px;">
                                                                <i class="fa fa-building"></i> Công ty:
                                                            </label>
                                                            <p style="margin: 0;">
                                                                <?= htmlspecialchars($transport['company']) ?>
                                                            </p>
                                                        </div>
                                                    <?php endif; ?>

                                                    <!-- Điểm đón khách -->
                                                    <?php if (!empty($transport['pickup_location']) || !empty($transport['pickup_time'])): ?>
                                                        <div style="background: #e8f5e9; padding: 10px; border-radius: 4px; margin-top: 8px;">
                                                            <h6 style="color: #2e7d32; margin: 0 0 8px 0; font-size: 13px;">
                                                                <i class="fa fa-map-marker"></i> Điểm đón khách
                                                            </h6>

                                                            <?php if (!empty($transport['pickup_location'])): ?>
                                                                <div class="info-group" style="margin-bottom: 6px;">
                                                                    <label style="font-size: 11px; color: #2e7d32; margin-bottom: 2px;">
                                                                        Địa điểm:
                                                                    </label>
                                                                    <p style="margin: 0; font-size: 13px; font-weight: 500;">
                                                                        <?= htmlspecialchars($transport['pickup_location']) ?>
                                                                    </p>
                                                                </div>
                                                            <?php endif; ?>

                                                            <?php if (!empty($transport['pickup_address'])): ?>
                                                                <div class="info-group" style="margin-bottom: 6px;">
                                                                    <label style="font-size: 11px; color: #2e7d32; margin-bottom: 2px;">
                                                                        Địa chỉ:
                                                                    </label>
                                                                    <p style="margin: 0; font-size: 12px;">
                                                                        <?= htmlspecialchars($transport['pickup_address']) ?>
                                                                    </p>
                                                                </div>
                                                            <?php endif; ?>

                                                            <?php if (!empty($transport['pickup_time'])): ?>
                                                                <div class="info-group">
                                                                    <label style="font-size: 11px; color: #2e7d32; margin-bottom: 2px;">
                                                                        Giờ khởi hành:
                                                                    </label>
                                                                    <p style="margin: 0; font-size: 15px; font-weight: bold; color: #d9534f;">
                                                                        <i class="fa fa-clock-o"></i>
                                                                        <?= htmlspecialchars(substr($transport['pickup_time'], 0, 5)) ?>
                                                                    </p>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endif; ?>

                                                    <!-- Tài xế -->
                                                    <?php if (!empty($transport['driver_name'])): ?>
                                                        <div style="border-top: 1px dashed #ddd; margin-top: 10px; padding-top: 10px;">
                                                            <h6 style="color: #337ab7; margin: 0 0 8px 0; font-size: 13px;">
                                                                <i class="fa fa-id-card"></i> Tài xế
                                                            </h6>

                                                            <div class="info-group" style="margin-bottom: 6px;">
                                                                <label style="font-size: 11px; color: #555; margin-bottom: 2px;">
                                                                    Tên:
                                                                </label>
                                                                <p style="margin: 0; font-weight: 500;">
                                                                    <?= htmlspecialchars($transport['driver_name']) ?>
                                                                </p>
                                                            </div>

                                                            <?php if (!empty($transport['driver_phone'])): ?>
                                                                <div class="info-group" style="margin-bottom: 6px;">
                                                                    <label style="font-size: 11px; color: #555; margin-bottom: 2px;">
                                                                        SĐT:
                                                                    </label>
                                                                    <p style="margin: 0;">
                                                                        <i class="fa fa-phone"></i>
                                                                        <?= htmlspecialchars($transport['driver_phone']) ?>
                                                                    </p>
                                                                </div>
                                                            <?php endif; ?>

                                                            <div class="row">
                                                                <?php if (!empty($transport['driver_cccd'])): ?>
                                                                    <div class="col-xs-6">
                                                                        <div class="info-group">
                                                                            <label style="font-size: 11px; color: #555; margin-bottom: 2px;">
                                                                                CCCD:
                                                                            </label>
                                                                            <p style="margin: 0; font-size: 12px;">
                                                                                <?= htmlspecialchars($transport['driver_cccd']) ?>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>

                                                                <?php if (!empty($transport['driver_birthdate'])): ?>
                                                                    <div class="col-xs-6">
                                                                        <div class="info-group">
                                                                            <label style="font-size: 11px; color: #555; margin-bottom: 2px;">
                                                                                Ngày sinh:
                                                                            </label>
                                                                            <p style="margin: 0; font-size: 12px;">
                                                                                <?= date('d/m/Y', strtotime($transport['driver_birthdate'])) ?>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
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
                                                <div style="background: #f9f9f9; padding: 12px; margin-bottom: 12px; border-radius: 5px; border-left: 3px solid #d9534f;">
                                                    <h5 style="color: #d9534f; margin-top: 0; margin-bottom: 10px; font-size: 15px;">
                                                        <i class="fa fa-hotel"></i> Khách sạn <?= $index + 1 ?>
                                                    </h5>

                                                    <div class="info-group" style="margin-bottom: 8px;">
                                                        <label style="font-size: 12px; color: #666; margin-bottom: 3px;">
                                                            <i class="fa fa-building-o"></i> Tên:
                                                        </label>
                                                        <p style="margin: 0; font-weight: 600;">
                                                            <?= htmlspecialchars($accommodation['name'] ?? 'N/A') ?>
                                                        </p>
                                                    </div>

                                                    <div class="info-group" style="margin-bottom: 8px;">
                                                        <label style="font-size: 12px; color: #666; margin-bottom: 3px;">
                                                            <i class="fa fa-bed"></i> Loại phòng:
                                                        </label>
                                                        <p style="margin: 0;">
                                                            <span style="background: #d9534f; color: white; padding: 3px 8px; border-radius: 10px; font-size: 11px;">
                                                                <?= htmlspecialchars($accommodation['type'] ?? 'Standard') ?>
                                                            </span>
                                                        </p>
                                                    </div>

                                                    <?php if (!empty($accommodation['sdt'])): ?>
                                                        <div class="info-group" style="margin-bottom: 8px;">
                                                            <label style="font-size: 12px; color: #666; margin-bottom: 3px;">
                                                                <i class="fa fa-phone"></i> Số điện thoại:
                                                            </label>
                                                            <p style="margin: 0;">
                                                                <?= htmlspecialchars($accommodation['sdt']) ?>
                                                            </p>
                                                        </div>
                                                    <?php endif; ?>

                                                    <div class="info-group">
                                                        <label style="font-size: 12px; color: #666; margin-bottom: 3px;">
                                                            <i class="fa fa-map-marker"></i> Địa chỉ:
                                                        </label>
                                                        <p style="margin: 0; color: #555;">
                                                            <?= htmlspecialchars($accommodation['address'] ?? 'N/A') ?>
                                                        </p>
                                                    </div>
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
                                                    <!-- <span style="margin-left: 15px; color: #666;"><?= date('d/m/Y', strtotime($schedule['date'])) ?></span> -->
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
                        <!-- LỊCH ĐIỂM DANH -->
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h4><i class="fa fa-calendar-check-o"></i> Lịch điểm danh</h4>
                            </div>
                            <div class="panel-body">
                                <?php
                                // Lấy dữ liệu điểm danh cho booking này
                                $attendances = !empty($booking['attendances']) ? $booking['attendances'] : [];
                                $attendanceSummary = !empty($booking['attendance_summary']) ? $booking['attendance_summary'] : [];
                                ?>

                                <?php if (!empty($attendanceSummary)): ?>

                                    <!-- FILTER CHỌN NGÀY -->
                                    <div class="attendance-date-filter">
                                        <div class="filter-header">
                                            <i class="fa fa-filter"></i>
                                            <span>Chọn ngày xem chi tiết:</span>
                                        </div>
                                        <div class="date-buttons-wrapper">
                                            <button class="date-filter-btn active" data-date="all" onclick="filterAttendanceByDate(<?= $booking['id'] ?>, 'all')">
                                                <i class="fa fa-calendar"></i>
                                                Tất cả ngày
                                            </button>
                                            <?php foreach ($attendanceSummary as $summary): ?>
                                                <button class="date-filter-btn" data-date="<?= $summary['attendance_date'] ?>"
                                                    onclick="filterAttendanceByDate(<?= $booking['id'] ?>, '<?= $summary['attendance_date'] ?>')">
                                                    <i class="fa fa-calendar-day"></i>
                                                    <?= $summary['formatted_date'] ?>
                                                    <span class="date-count">(<?= $summary['present_count'] + $summary['absent_count'] ?>)</span>
                                                </button>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>

                                    <!-- TỔNG QUAN THEO NGÀY -->
                                    <div class="attendance-summary-cards">
                                        <?php foreach ($attendanceSummary as $summary): ?>
                                            <div class="attendance-summary-card">
                                                <div class="summary-date">
                                                    <i class="fa fa-calendar"></i>
                                                    <?= $summary['formatted_date'] ?>
                                                </div>
                                                <div class="summary-stats">
                                                    <div class="stat-item stat-present">
                                                        <i class="fa fa-check-circle"></i>
                                                        <span><?= $summary['present_count'] ?> Có mặt</span>
                                                    </div>
                                                    <div class="stat-item stat-absent">
                                                        <i class="fa fa-times-circle"></i>
                                                        <span><?= $summary['absent_count'] ?> Vắng mặt</span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <!-- CHI TIẾT ĐIỂM DANH -->
                                    <h6 style="margin-top: 30px; margin-bottom: 20px; color: #34495e; font-weight: 600;">
                                        <i class="fa fa-list"></i> Chi tiết điểm danh
                                    </h6>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover attendance-table">
                                            <thead>
                                                <tr>
                                                    <th width="5%">STT</th>
                                                    <th width="20%">Họ và Tên</th>
                                                    <th width="12%">Ngày Sinh</th>
                                                    <th width="12%">SĐT</th>
                                                    <th width="12%">Ngày</th>
                                                    <th width="10%">Buổi</th>
                                                    <th width="10%">Giờ</th>
                                                    <th width="10%">Trạng Thái</th>
                                                    <th width="9%">Ghi Chú</th>
                                                </tr>
                                            </thead>
                                            <tbody id="attendance-table-body-<?= $booking['id'] ?>">
                                                <?php
                                                $stt = 0;
                                                foreach ($attendances as $attendance):
                                                    $stt++;
                                                ?>
                                                    <tr class="attendance-row" data-date="<?= $attendance['attendance_date'] ?>">
                                                        <td class="text-center"><?= $stt ?></td>
                                                        <td>
                                                            <i class="fa fa-user"></i>
                                                            <strong><?= htmlspecialchars($attendance['fullname']) ?></strong>
                                                        </td>
                                                        <td>
                                                            <i class="fa fa-birthday-cake"></i>
                                                            <?= date('d/m/Y', strtotime($attendance['date'])) ?>
                                                        </td>
                                                        <td>
                                                            <i class="fa fa-phone"></i>
                                                            <?= htmlspecialchars($attendance['phone']) ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="date-badge">
                                                                <?= $attendance['formatted_date'] ?>
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php if ($attendance['session'] === 'morning'): ?>
                                                                <span class="session-badge session-morning">
                                                                    <i class="fa fa-sun-o"></i> Sáng
                                                                </span>
                                                            <?php elseif ($attendance['session'] === 'afternoon'): ?>
                                                                <span class="session-badge session-afternoon">
                                                                    <i class="fa fa-cloud"></i> Chiều
                                                                </span>
                                                            <?php elseif ($attendance['session'] === 'evening'): ?>
                                                                <span class="session-badge session-evening">
                                                                    <i class="fa fa-moon-o"></i> Tối
                                                                </span>
                                                            <?php else: ?>
                                                                <span class="session-badge session-default">
                                                                    <?= htmlspecialchars($attendance['session'] ?? 'N/A') ?>
                                                                </span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php if (!empty($attendance['checkin_time'])): ?>
                                                                <span class="check-time-badge">
                                                                    <i class="fa fa-clock-o"></i>
                                                                    <?= date('H:i', strtotime($attendance['checkin_time'])) ?>
                                                                </span>
                                                            <?php else: ?>
                                                                <span class="text-muted">-</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php if ($attendance['status'] === 'present'): ?>
                                                                <span class="status-badge status-present">
                                                                    <i class="fa fa-check-circle"></i> Có mặt
                                                                </span>
                                                            <?php else: ?>
                                                                <span class="status-badge status-absent">
                                                                    <i class="fa fa-times-circle"></i> Vắng
                                                                </span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?= htmlspecialchars($attendance['note'] ?? '-') ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- No data message -->
                                    <div id="no-attendance-data-<?= $booking['id'] ?>" style="display: none;" class="no-data-message">
                                        <i class="fa fa-exclamation-circle"></i>
                                        <p>Không có dữ liệu điểm danh cho ngày đã chọn</p>
                                    </div>

                                <?php else: ?>
                                    <div class="no-data-message">
                                        <i class="fa fa-exclamation-circle"></i>
                                        <p>Chưa có dữ liệu điểm danh</p>
                                    </div>
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
<style>
    /* ==================== ATTENDANCE STYLES ==================== */
    .attendance-date-filter {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        border-left: 5px solid #667eea;
    }

    .filter-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
        font-size: 16px;
        font-weight: 700;
        color: #2c3e50;
    }

    .filter-header i {
        color: #667eea;
    }

    .date-buttons-wrapper {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .date-filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        background: white;
        border: 2px solid #e0e0e0;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        color: #555;
        cursor: pointer;
        transition: all 0.3s;
    }

    .date-filter-btn:hover {
        background: #f8f9ff;
        border-color: #667eea;
        color: #667eea;
        transform: translateY(-2px);
    }

    .date-filter-btn.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
        color: white;
    }

    .date-count {
        background: rgba(255, 255, 255, 0.3);
        padding: 2px 6px;
        border-radius: 10px;
        font-size: 11px;
    }

    .attendance-summary-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 25px;
    }

    .attendance-summary-card {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border-left: 4px solid #3498db;
    }

    .summary-date {
        font-size: 14px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .summary-stats {
        display: flex;
        gap: 12px;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
        font-weight: 600;
    }

    .stat-present {
        color: #27ae60;
    }

    .stat-absent {
        color: #e74c3c;
    }

    .attendance-table thead {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        color: white;
    }

    .attendance-table thead th {
        font-weight: 600;
        padding: 12px;
        font-size: 12px;
    }

    .attendance-table tbody tr:hover {
        background: #e3f2fd;
    }

    .attendance-table tbody td {
        padding: 10px;
        font-size: 12px;
    }

    .date-badge {
        background: #5bc0de;
        color: white;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
    }

    .session-badge {
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
    }

    .session-morning {
        background: #fff3cd;
        color: #856404;
    }

    .session-afternoon {
        background: #d1ecf1;
        color: #0c5460;
    }

    .session-evening {
        background: #d6d8db;
        color: #383d41;
    }

    .check-time-badge {
        background: #28a745;
        color: white;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
    }

    .status-badge {
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
    }

    .status-present {
        background: #d4edda;
        color: #155724;
    }

    .status-absent {
        background: #f8d7da;
        color: #721c24;
    }

    .no-data-message {
        text-align: center;
        padding: 40px 20px;
        color: #7f8c8d;
    }

    .no-data-message i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
    }
</style>
<script>
    function filterAttendanceByDate(bookingId, selectedDate) {
        // Update active button
        const buttons = document.querySelectorAll(`[data-date]`);
        buttons.forEach(btn => {
            btn.classList.remove('active');
            if (btn.getAttribute('data-date') === selectedDate) {
                btn.classList.add('active');
            }
        });

        // Filter table rows
        const rows = document.querySelectorAll(`#attendance-table-body-${bookingId} .attendance-row`);
        const noDataDiv = document.getElementById(`no-attendance-data-${bookingId}`);
        const tableDiv = document.getElementById(`attendance-table-body-${bookingId}`).closest('.table-responsive');
        let visibleCount = 0;
        let stt = 0;

        rows.forEach(row => {
            const rowDate = row.getAttribute('data-date');

            if (selectedDate === 'all' || rowDate === selectedDate) {
                row.style.display = '';
                stt++;
                row.querySelector('td:first-child').textContent = stt;
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Show/hide no data message
        if (visibleCount === 0) {
            noDataDiv.style.display = 'block';
            tableDiv.style.display = 'none';
        } else {
            noDataDiv.style.display = 'none';
            tableDiv.style.display = 'block';
        }
    }

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