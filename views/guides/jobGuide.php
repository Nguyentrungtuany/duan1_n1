<?php
require_once 'views/layout/guides/header.php';
?>
<style>
    .booking-card {
        background: #fff;
        border-radius: 10px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .booking-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px;
    }

    .booking-header h3 {
        color: white;
        margin: 0 0 10px 0;
        font-size: 24px;
    }

    .info-section {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .schedule-item {
        background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
        border-left: 4px solid #667eea;
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 8px;
    }

    .person-card {
        background: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 10px;
    }

    .stats-box {
        background: white;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
    }

    .label {
        font-size: 12px;
        padding: 5px 10px;
    }
</style>

<!-- Main Content -->
<div id="page-wrapper">
    <div class="main-page">
        <!-- Page Title -->
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
                    <h3><?php echo $total; ?></h3>
                    <p>Tổng công việc</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-box">
                    <i class="fa fa-clock-o fa-3x text-warning pull-right"></i>
                    <h3 class="text-warning"><?php echo $pending; ?></h3>
                    <p>Chờ xác nhận</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-box">
                    <i class="fa fa-check-circle fa-3x text-info pull-right"></i>
                    <h3 class="text-info"><?php echo $confirmed; ?></h3>
                    <p>Đã xác nhận</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-box">
                    <i class="fa fa-check-square fa-3x text-success pull-right"></i>
                    <h3 class="text-success"><?php echo $completed; ?></h3>
                    <p>Hoàn thành</p>
                </div>
            </div>
        </div>

        <!-- Filter Buttons -->
        <div class="filter-buttons">
            <button class="btn btn-primary filter-btn" data-filter="all">
                <i class="fa fa-list"></i> Tất cả (<?php echo $total; ?>)
            </button>
            <button class="btn btn-warning filter-btn" data-filter="pending">
                <i class="fa fa-clock-o"></i> Chờ xác nhận (<?php echo $pending; ?>)
            </button>
            <button class="btn btn-info filter-btn" data-filter="confirmed">
                <i class="fa fa-check-circle"></i> Đã xác nhận (<?php echo $confirmed; ?>)
            </button>
            <button class="btn btn-success filter-btn" data-filter="completed">
                <i class="fa fa-check-square"></i> Hoàn thành (<?php echo $completed; ?>)
            </button>
        </div>

        <!-- Bookings List -->
        <?php if (empty($bookings)): ?>
            <div class="alert alert-info text-center">
                <i class="fa fa-inbox fa-3x"></i>
                <h4>Không có công việc nào</h4>
            </div>
        <?php else: ?>
            <?php foreach ($bookings as $booking): ?>
                <div class="booking-card" data-status="<?php echo $booking['status']; ?>">
                    <!-- Header -->
                    <div class="booking-header">
                        <div class="row">
                            <div class="col-md-8">
                                <h3><?php echo htmlspecialchars($booking['tour']['name']); ?></h3>
                                <p style="margin: 0; color: rgba(255,255,255,0.9);">
                                    <i class="fa fa-map-marker"></i> <?php echo htmlspecialchars($booking['destination']['name']); ?> &nbsp;&nbsp;
                                    <i class="fa fa-calendar"></i> <?php echo formatDate($booking['start_date']); ?> - <?php echo formatDate($booking['end_date']); ?> &nbsp;&nbsp;
                                    <i class="fa fa-users"></i> <?php echo $booking['number_of_people']; ?> người
                                </p>
                            </div>
                            <div class="col-md-4 text-right">
                                <h2 style="color: white; margin: 0 0 10px 0;"><?php echo formatCurrency($booking['tour']['price']); ?></h2>
                                <div>
                                    <?php echo getStatusBadge($booking['status']); ?>
                                    <?php echo getPaymentBadge($booking['payment_status']); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div style="padding: 20px;">
                        <div class="row">
                            <!-- Customer Info -->
                            <div class="col-md-6">
                                <h4><i class="fa fa-user"></i> Thông tin khách hàng</h4>
                                <div class="info-section">
                                    <p><strong>Tên:</strong> <?php echo htmlspecialchars($booking['customer']['full_name']); ?></p>
                                    <p><i class="fa fa-phone"></i> <?php echo htmlspecialchars($booking['customer']['phone']); ?></p>
                                    <p><i class="fa fa-envelope"></i> <?php echo htmlspecialchars($booking['customer']['email']); ?></p>
                                    <?php if (!empty($booking['customer']['type'])): ?>
                                        <span class="label label-primary"><?php echo strtoupper($booking['customer']['type']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Tour Info -->
                            <div class="col-md-6">
                                <h4><i class="fa fa-map"></i> Thông tin tour</h4>
                                <div class="info-section">
                                    <p><strong>Loại:</strong> <?php echo htmlspecialchars($booking['category']['name']); ?></p>
                                    <p><strong>Điểm đến:</strong> <?php echo htmlspecialchars($booking['destination']['name']); ?></p>
                                    <p><strong>Vị trí:</strong> <?php echo htmlspecialchars($booking['destination']['location']); ?></p>
                                    <p><strong>Mô tả:</strong> <?php echo htmlspecialchars($booking['tour']['description'] ?? ''); ?></p>
                                </div>
                            </div>

                            <!-- Special Request -->
                            <?php if (!empty($booking['special_request'])): ?>
                                <div class="col-md-12">
                                    <h4><i class="fa fa-exclamation-triangle text-warning"></i> Yêu cầu đặc biệt</h4>
                                    <div class="alert alert-warning">
                                        <?php echo htmlspecialchars($booking['special_request']); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Transport -->
                            <?php if (!empty($booking['transports'])): ?>
                                <div class="col-md-6">
                                    <h4><i class="fa fa-bus"></i> Phương tiện</h4>
                                    <?php foreach ($booking['transports'] as $transport): ?>
                                        <div class="info-section">
                                            <p><strong>Loại:</strong> <?php echo htmlspecialchars($transport['type']); ?></p>
                                            <?php if (!empty($transport['company'])): ?>
                                                <p><strong>Công ty:</strong> <?php echo htmlspecialchars($transport['company']); ?></p>
                                            <?php endif; ?>
                                            <p><strong>Số chỗ:</strong> <?php echo $transport['seats']; ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Accommodations -->
                            <?php if (!empty($booking['accommodations'])): ?>
                                <div class="col-md-6">
                                    <h4><i class="fa fa-hotel"></i> Chỗ ở</h4>
                                    <?php foreach ($booking['accommodations'] as $acc): ?>
                                        <div class="info-section">
                                            <p><strong><?php echo htmlspecialchars($acc['name']); ?></strong></p>
                                            <p class="text-muted"><?php echo htmlspecialchars($acc['address']); ?></p>
                                            <span class="label label-info"><?php echo htmlspecialchars($acc['type']); ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Schedules -->
                            <?php if (!empty($booking['schedules'])): ?>
                                <div class="col-md-12">
                                    <h4><i class="fa fa-calendar-check-o"></i> Lịch trình</h4>
                                    <?php foreach ($booking['schedules'] as $schedule): ?>
                                        <div class="schedule-item">
                                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                                <strong style="color: #667eea;">Ngày <?php echo $schedule['day_number']; ?></strong>
                                                <span class="text-muted"><?php echo formatDate($schedule['date']); ?></span>
                                            </div>
                                            <p><strong>Địa điểm:</strong> <?php echo htmlspecialchars($schedule['location']); ?></p>
                                            <p><strong>Hoạt động:</strong> <?php echo htmlspecialchars($schedule['activities']); ?></p>
                                            <?php if (!empty($schedule['notes'])): ?>
                                                <p class="text-muted"><small><strong>Ghi chú:</strong> <?php echo htmlspecialchars($schedule['notes']); ?></small></p>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <!-- People -->
                            <?php if (!empty($booking['people'])): ?>
                                <div class="col-md-12">
                                    <h4><i class="fa fa-users"></i> Danh sách người tham gia (<?php echo count($booking['people']); ?>)</h4>
                                    <div class="row">
                                        <?php foreach ($booking['people'] as $person): ?>
                                            <div class="col-md-4">
                                                <div class="person-card">
                                                    <p style="margin: 0; font-weight: bold;"><?php echo htmlspecialchars($person['fullname']); ?></p>
                                                    <p style="margin: 5px 0;" class="text-muted"><?php echo htmlspecialchars($person['phone']); ?></p>
                                                    <small class="text-muted"><?php echo formatDate($person['date']); ?></small>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Customer Support -->
                            <?php if (!empty($booking['customer_support'])): ?>
                                <div class="col-md-12">
                                    <h4><i class="fa fa-headphones"></i> Hỗ trợ khách hàng</h4>
                                    <?php foreach ($booking['customer_support'] as $support): ?>
                                        <div class="alert alert-info">
                                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                                <?php
                                                $supportBadge = $support['status'] === 'resolved'
                                                    ? '<span class="label label-success">Đã giải quyết</span>'
                                                    : '<span class="label label-warning">Đang xử lý</span>';
                                                echo $supportBadge;
                                                ?>
                                                <small class="text-muted"><?php echo $support['created_at']; ?></small>
                                            </div>
                                            <p style="margin: 0;"><?php echo htmlspecialchars($support['message']); ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Footer -->
                        <div style="border-top: 1px solid #ddd; padding-top: 15px; margin-top: 20px;">
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        Tạo: <?php echo $booking['created_at']; ?><br>
                                        Cập nhật: <?php echo $booking['updated_at']; ?>
                                    </small>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button class="btn btn-primary">
                                        <i class="fa fa-eye"></i> Chi tiết
                                    </button>
                                    <?php if ($booking['status'] === 'pending'): ?>
                                        <button class="btn btn-success">
                                            <i class="fa fa-check"></i> Xác nhận
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
    // Filter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.filter-btn');

        filterButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const filter = this.dataset.filter;

                // Update active button
                filterButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                // Filter cards
                document.querySelectorAll('.booking-card').forEach(card => {
                    if (filter === 'all' || card.dataset.status === filter) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
<?php
require_once 'views/layout/guides/footer.php';
?>