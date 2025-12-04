<?php
require_once __DIR__ . '/../../layout/admin/header.php';

// Giải mã JSON an toàn cho booking detail
if (!empty($booking)) {
    $booking['destination'] = !empty($booking['destination']) ? json_decode($booking['destination'], true) : [];
    $booking['transports'] = !empty($booking['transports']) ? json_decode($booking['transports'], true) : [];
    $booking['accommodations'] = !empty($booking['accommodations']) ? json_decode($booking['accommodations'], true) : [];
    $booking['schedules'] = !empty($booking['schedules']) ? json_decode($booking['schedules'], true) : [];
    $booking['tour'] = !empty($booking['tour']) ? json_decode($booking['tour'], true) : [];
    $booking['customer'] = !empty($booking['customer']) ? json_decode($booking['customer'], true) : [];
    $booking['people'] = !empty($booking['people']) ? json_decode($booking['people'], true) : [];
    $booking['category'] = !empty($booking['category']) ? json_decode($booking['category'], true) : [];
    $booking['guide'] = !empty($booking['guide']) ? json_decode($booking['guide'], true) : [];
    $booking['user'] = !empty($booking['user']) ? json_decode($booking['user'], true) : [];
}
var_dump($booking);
?>

<!-- main content start-->
<div id="page-wrapper">
    <div class="main-page">
        <div class="booking-detail">
            <div style="margin-bottom: 20px;">
                <a href="index.php?act=bookings-list" class="btn btn-default">
                    <i class="fa fa-arrow-left"></i> Quay lại danh sách
                </a>
                <a href="index.php?act=bookings-edit&id=<?= $booking['id'] ?>" class="btn btn-primary">
                    <i class="fa fa-edit"></i> Chỉnh sửa
                </a>
            </div>

            <h2 class="title1">Chi Tiết Booking #<?= htmlspecialchars($booking['id']) ?></h2>

            <!-- THÔNG TIN CHUNG -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4><i class="fa fa-info-circle"></i> Thông tin chung</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-group">
                                <label>Mã Booking:</label>
                                <p><strong>#<?= htmlspecialchars($booking['id']) ?></strong></p>
                            </div>
                            <div class="info-group">
                                <label>Trạng thái:</label>
                                <p>
                                    <span class="label <?= $booking['status'] == 'open' ? 'label-success' : 'label-default' ?>" style="font-size: 14px; padding: 5px 10px;">
                                        <?= htmlspecialchars($booking['status']) ?>
                                    </span>
                                </p>
                            </div>
                            <div class="info-group">
                                <label>Số lượng người:</label>
                                <p><strong><?= htmlspecialchars($booking['number_of_people'] ?? 0) ?> người</strong></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-group">
                                <label>Ngày bắt đầu:</label>
                                <p><?= date('d/m/Y', strtotime($booking['start_date'])) ?></p>
                            </div>
                            <div class="info-group">
                                <label>Ngày kết thúc:</label>
                                <p><?= date('d/m/Y', strtotime($booking['end_date'])) ?></p>
                            </div>
                            <div class="info-group">
                                <label>Cập nhật lần cuối:</label>
                                <p><?= date('d/m/Y H:i:s', strtotime($booking['updated_at'])) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- THÔNG TIN TOUR -->
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4><i class="fa fa-suitcase"></i> Thông tin Tour</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="info-group">
                                <label>Tên Tour:</label>
                                <p><strong style="font-size: 16px;"><?= htmlspecialchars($booking['tour']['name'] ?? 'Chưa có tên tour') ?></strong></p>
                            </div>
                            <div class="info-group">
                                <label>Danh mục:</label>
                                <p><?= htmlspecialchars($booking['category']['name'] ?? 'Chưa phân loại') ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-group">
                                <label>Giá tour:</label>
                                <p><strong style="font-size: 18px; color: #d9534f;">
                                        <?= isset($booking['tour']['price']) ? number_format($booking['tour']['price'], 0, ',', '.') . ' VNĐ' : 'Chưa có giá' ?>
                                    </strong></p>
                            </div>
                            <div class="info-group">
                                <label>Tổng tiền:</label>
                                <p><strong style="font-size: 20px; color: #5cb85c;">
                                        <?php
                                        $total = ($booking['tour']['price'] ?? 0) * ($booking['number_of_people'] ?? 0);
                                        echo number_format($total, 0, ',', '.') . ' VNĐ';
                                        ?>
                                    </strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ĐIỂM ĐẾN -->
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h4><i class="fa fa-map-marker"></i> Điểm đến</h4>
                </div>
                <div class="panel-body">
                    <?php if (!empty($booking['destination'])): ?>
                        <div class="info-group">
                            <label>Tên điểm đến:</label>
                            <p><strong style="font-size: 16px;"><?= htmlspecialchars($booking['destination']['name'] ?? 'Không có tên') ?></strong></p>
                        </div>
                        <div class="info-group">
                            <label>Địa điểm:</label>
                            <p><?= htmlspecialchars($booking['destination']['location'] ?? 'Không có địa điểm') ?></p>
                        </div>
                        <div class="info-group">
                            <label>Mô tả:</label>
                            <p style="line-height: 1.6;"><?= htmlspecialchars($booking['destination']['description'] ?? 'Chưa có mô tả') ?></p>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Chưa có thông tin điểm đến</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- HƯỚNG DẪN VIÊN -->
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h4><i class="fa fa-user"></i> Hướng dẫn viên</h4>
                </div>
                <div class="panel-body">
                    <?php if (!empty($booking['guide']) && is_array($booking['guide'])): ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-group">
                                    <label>Họ và tên:</label>
                                    <p><strong><?= htmlspecialchars($booking['guide']['full_name'] ?? 'Chưa có tên') ?></strong></p>
                                </div>
                                <div class="info-group">
                                    <label>Email:</label>
                                    <p><i class="fa fa-envelope"></i> <?= htmlspecialchars($booking['user']['email'] ?? 'Chưa có email') ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-group">
                                    <label>Số điện thoại:</label>
                                    <p><i class="fa fa-phone"></i> <?= htmlspecialchars($booking['user']['phone'] ?? 'Chưa có SĐT') ?></p>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Chưa có thông tin hướng dẫn viên</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- PHƯƠNG TIỆN -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4><i class="fa fa-bus"></i> Phương tiện di chuyển</h4>
                </div>
                <div class="panel-body">
                    <?php if (!empty($booking['transports'])): ?>
                        <div class="row">
                            <?php foreach ($booking['transports'] as $index => $transport): ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="transport-card">
                                        <h5><strong>Phương tiện <?= $index + 1 ?></strong></h5>
                                        <div class="info-group">
                                            <label>Loại phương tiện:</label>
                                            <p><?= htmlspecialchars($transport['type']) ?></p>
                                        </div>
                                        <div class="info-group">
                                            <label>Số chỗ:</label>
                                            <p><i class="fa fa-users"></i> <?= $transport['seats'] ?> chỗ</p>
                                        </div>
                                        <div class="info-group">
                                            <label>Công ty:</label>
                                            <p><i class="fa fa-building"></i> <?= htmlspecialchars($transport['company']) ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Chưa có thông tin phương tiện</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- KHÁCH SẠN -->
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h4><i class="fa fa-hotel"></i> Chỗ ở</h4>
                </div>
                <div class="panel-body">
                    <?php if (!empty($booking['accommodations'])): ?>
                        <div class="row">
                            <?php foreach ($booking['accommodations'] as $index => $accommodation): ?>
                                <div class="col-md-6">
                                    <div class="accommodation-card">
                                        <h5><strong>Khách sạn <?= $index + 1 ?></strong></h5>
                                        <div class="info-group">
                                            <label>Tên khách sạn:</label>
                                            <p><strong><?= htmlspecialchars($accommodation['name']) ?></strong></p>
                                        </div>
                                        <div class="info-group">
                                            <label>Loại phòng:</label>
                                            <p><i class="fa fa-bed"></i> <?= htmlspecialchars($accommodation['type']) ?></p>
                                        </div>
                                        <div class="info-group">
                                            <label>Địa chỉ:</label>
                                            <p><i class="fa fa-map-marker"></i> <?= htmlspecialchars($accommodation['address']) ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Chưa có thông tin chỗ ở</p>
                    <?php endif; ?>
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
                                <div class="schedule-body">
                                    <div class="info-group">
                                        <label><i class="fa fa-map-marker"></i> Địa điểm:</label>
                                        <p><strong><?= htmlspecialchars($schedule['location']) ?></strong></p>
                                    </div>
                                    <div class="info-group">
                                        <label><i class="fa fa-list"></i> Hoạt động:</label>
                                        <p style="line-height: 1.6;"><?= nl2br(htmlspecialchars($schedule['activities'])) ?></p>
                                    </div>
                                    <?php if (!empty($schedule['notes'])): ?>
                                        <div class="info-group">
                                            <label><i class="fa fa-info-circle"></i> Ghi chú:</label>
                                            <p style="color: #d9534f; font-style: italic;"><?= htmlspecialchars($schedule['notes']) ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted">Chưa có lịch trình</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- DANH SÁCH KHÁCH HÀNG -->
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h4><i class="fa fa-users"></i> Danh sách khách hàng</h4>
                </div>
                <div class="panel-body">
                    <?php if (!empty($booking['people'])): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Họ và tên</th>
                                        <th>Ngày sinh</th>
                                        <th>Số điện thoại</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($booking['people'] as $index => $person): ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><strong><?= htmlspecialchars($person['fullname']) ?></strong></td>
                                            <td><?= htmlspecialchars($person['date']) ?></td>
                                            <td><i class="fa fa-phone"></i> <?= htmlspecialchars($person['phone']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Chưa có danh sách khách hàng</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    html,
    body {
        overflow: auto !important;
        height: auto !important;
    }

    .booking-detail {
        padding: 20px;
    }

    .panel {
        margin-bottom: 25px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .panel-heading h4 {
        margin: 0;
        font-weight: bold;
    }

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
        padding: 8px;
        background: #f9f9f9;
        border-left: 3px solid #337ab7;
        border-radius: 3px;
    }

    .transport-card,
    .accommodation-card {
        background: #f5f5f5;
        border: 1px solid #ddd;
        border-left: 4px solid #337ab7;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 4px;
    }

    .transport-card h5,
    .accommodation-card h5 {
        margin-top: 0;
        color: #337ab7;
        border-bottom: 2px solid #337ab7;
        padding-bottom: 8px;
        margin-bottom: 15px;
    }

    .accommodation-card {
        border-left-color: #f484f4ff;
    }

    .accommodation-card h5 {
        color: #f484f4ff;
        border-bottom-color: #f484f4ff;
    }

    .schedule-card {
        background: #fff;
        border: 2px solid #5cb85c;
        border-radius: 6px;
        margin-bottom: 20px;
        overflow: hidden;
    }

    .schedule-header {
        background: linear-gradient(135deg, #5cb85c 0%, #4cae4c 100%);
        padding: 15px 20px;
        color: white;
    }

    .schedule-header h4 {
        margin: 0;
        color: white;
    }

    .schedule-body {
        padding: 20px;
    }

    .schedule-body .info-group {
        margin-bottom: 15px;
    }

    .schedule-body .info-group label {
        color: #5cb85c;
        font-size: 14px;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead {
        background: #f5f5f5;
    }

    .table thead th {
        font-weight: bold;
        color: #333;
    }

    @media print {
        .btn {
            display: none;
        }
    }
</style>

<?php require_once __DIR__ . '/../../layout/admin/footer.php'; ?>