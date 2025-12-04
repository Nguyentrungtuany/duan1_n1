<?php
require_once __DIR__ . '/../../layout/admin/header.php';

// Decode JSON data nếu cần
if (isset($booking['tour']) && is_string($booking['tour'])) {
    $booking['tour'] = json_decode($booking['tour'], true);
}
if (isset($booking['customer']) && is_string($booking['customer'])) {
    $booking['customer'] = json_decode($booking['customer'], true);
}
if (isset($booking['destination']) && is_string($booking['destination'])) {
    $booking['destination'] = json_decode($booking['destination'], true);
}
if (isset($booking['transports']) && is_string($booking['transports'])) {
    $booking['transports'] = json_decode($booking['transports'], true);
}
if (isset($booking['people']) && is_string($booking['people'])) {
    $booking['people'] = json_decode($booking['people'], true);
}
if (isset($booking['schedules']) && is_string($booking['schedules'])) {
    $booking['schedules'] = json_decode($booking['schedules'], true);
}
if (isset($booking['customer_support']) && is_string($booking['customer_support'])) {
    $booking['customer_support'] = json_decode($booking['customer_support'], true);
}
if (isset($booking['accommodations']) && is_string($booking['accommodations'])) {
    $booking['accommodations'] = json_decode($booking['accommodations'], true);
}
if (isset($booking['category']) && is_string($booking['category'])) {
    $booking['category'] = json_decode($booking['category'], true);
}
if (isset($booking['user']) && is_string($booking['user'])) {
    $booking['user'] = json_decode($booking['user'], true);
}
if (isset($booking['guide']) && is_string($booking['guide'])) {
    $booking['guide'] = json_decode($booking['guide'], true);
}
?>

<!-- main content start-->
<div id="page-wrapper">
    <div class="main-page">
        <div class="forms">
            <h2 class="title1">Cập nhật booking</h2>

            <!-- ✅ ALERT MESSAGES BÊN TRONG PAGE-WRAPPER -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible" role="alert" style="margin-bottom: 20px;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="fa fa-exclamation-circle"></i>
                    <strong>Lỗi!</strong> <?= htmlspecialchars($_SESSION['error']) ?>
                </div>
            <?php unset($_SESSION['error']);
            endif; ?>

            <?php if (isset($_SESSION['warning'])): ?>
                <div class="alert alert-warning alert-dismissible" role="alert" style="margin-bottom: 20px;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="fa fa-warning"></i>
                    <strong>Cảnh báo!</strong> <?= htmlspecialchars($_SESSION['warning']) ?>
                </div>
            <?php unset($_SESSION['warning']);
            endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible" role="alert" style="margin-bottom: 20px;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="fa fa-check-circle"></i>
                    <strong>Thành công!</strong> <?= htmlspecialchars($_SESSION['success']) ?>
                </div>
            <?php unset($_SESSION['success']);
            endif; ?>

            <div class="form-grids row widget-shadow" data-example-id="basic-forms">
                <div class="form-title">
                    <h4>Form cập nhật thông tin booking</h4>
                </div>
                <div class="form-body">
                    <form method="POST" action="<?php echo BASE_URL; ?>index.php?act=bookings-update" enctype="multipart/form-data">
                        <!-- Hidden ID -->
                        <input type="hidden" name="id" value="<?php echo isset($booking['id']) ? $booking['id'] : ''; ?>">

                        <h4 class="text-primary" style="margin-top: 20px; margin-bottom: 15px; border-bottom: 2px solid #337ab7; padding-bottom: 10px;">
                            <i class="fa fa-info-circle"></i> Thông tin cơ bản
                        </h4>

                        <!-- Tên Tour -->
                        <div class="form-group">
                            <label for="name">Tên Tour <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="<?php echo isset($booking['tour']['name']) ? htmlspecialchars($booking['tour']['name']) : ''; ?>"
                                placeholder="Nhập tên tour" required>
                        </div>

                        <!-- Danh mục -->
                        <div class="form-group">
                            <label for="category_id">Danh mục <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="category_id" category_id="category_id"
                                value="<?php echo isset($booking['category']['name']) ? htmlspecialchars($booking['category']['name']) : ''; ?>"
                                placeholder="Nhập tên tour" disabled>
                        </div>

                        <!-- HDV -->
                        <div class="form-group">
                            <label for="guide_id">Hướng Dẫn Viên <span class="text-danger">*</span></label>
                            <select class="form-control" id="guide_id" name="guide_id" required>
                                <option value="">-- Chọn Hướng Dẫn Viên --</option>
                                <?php foreach ($allGuide as $gui): ?>
                                    <option value="<?= $gui['id'] ?>"
                                        <?= isset($booking['guide_id']) && $booking['guide_id'] == $gui['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($gui['full_name']) ?>
                                        (<?= htmlspecialchars($gui['phone']) ?>)
                                        (<?= htmlspecialchars($gui['email']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Điểm đến (Tour) -->
                        <div class="form-group">
                            <label for="tour_id">Điểm đến <span class="text-danger">*</span></label>
                            <select class="form-control" id="tour_id" name="tour_id" required>
                                <option value="">-- Chọn điểm đến --</option>
                                <?php foreach ($allTour as $tour):
                                    $tourSchedules = [];
                                    if (isset($tour['schedules'])) {
                                        $tourSchedules = is_string($tour['schedules'])
                                            ? json_decode($tour['schedules'], true)
                                            : $tour['schedules'];
                                    }
                                    $isSelected = (isset($booking['tour_id']) && $booking['tour_id'] == $tour['id']);
                                ?>
                                    <option value="<?= $tour['id'] ?>"
                                        data-name="<?= htmlspecialchars($tour['name']) ?>"
                                        data-price="<?= $tour['price'] ?>"
                                        data-description="<?= htmlspecialchars($tour['description'] ?? '') ?>"
                                        data-category="<?= $tour['category_id'] ?>"
                                        data-start="<?= $tour['start_date'] ?? '' ?>"
                                        data-end="<?= $tour['end_date'] ?? '' ?>"
                                        data-schedules='<?= htmlspecialchars(json_encode($tourSchedules ?: []), ENT_QUOTES, 'UTF-8') ?>'
                                        <?= $isSelected ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($tour['name']) ?> - <?= number_format($tour['price']) ?> VNĐ
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Mô tả -->
                        <div class="form-group">
                            <label for="description">Mô tả <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="4"
                                placeholder="Nhập mô tả tour"><?php echo isset($booking['tour']['description']) ? htmlspecialchars($booking['tour']['description']) : ''; ?></textarea>
                        </div>

                        <!-- Yêu cầu -->
                        <div class="form-group">
                            <label for="special_request">Yêu cầu đặc biệt</label>
                            <textarea class="form-control" id="special_request" name="special_request" rows="4"
                                placeholder="Nhập yêu cầu đặc biệt"><?php echo isset($booking['special_request']) ? htmlspecialchars($booking['special_request']) : ''; ?></textarea>
                        </div>

                        <!-- Ngày bắt đầu và Ngày kết thúc -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date">Ngày bắt đầu <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                        value="<?php echo isset($booking['start_date']) ? $booking['start_date'] : ''; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_date">Ngày kết thúc <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                        value="<?php echo isset($booking['end_date']) ? $booking['end_date'] : ''; ?>" required>
                                </div>
                            </div>
                        </div>

                        <!-- Giá -->
                        <div class="form-group">
                            <label for="price">Giá (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="price" name="price"
                                value="<?php echo isset($booking['tour']['price']) ? $booking['tour']['price'] : ''; ?>"
                                placeholder="Nhập giá tour" min="0" required>
                        </div>

                        <!-- Trạng thái -->
                        <div class="form-group">
                            <label for="status">Trạng thái</label>
                            <select class="form-control" id="status" name="status">
                                <option value="pending" <?php echo (isset($booking['status']) && $booking['status'] == 'pending') ? 'selected' : ''; ?>>Đang chờ xử lý</option>
                                <option value="confirmed" <?php echo (isset($booking['status']) && $booking['status'] == 'confirmed') ? 'selected' : ''; ?>>Đã xác nhận</option>
                                <option value="cancelled" <?php echo (isset($booking['status']) && $booking['status'] == 'cancelled') ? 'selected' : ''; ?>>Đã hủy</option>
                                <option value="completed" <?php echo (isset($booking['status']) && $booking['status'] == 'completed') ? 'selected' : ''; ?>>Hoàn thành</option>
                            </select>
                        </div>

                        <!-- Chuyển tiền -->
                        <div class="form-group">
                            <label for="payment_status">Trạng thái thanh toán</label>
                            <select class="form-control" id="payment_status" name="payment_status">
                                <option value="unpaid" <?php echo (isset($booking['payment_status']) && $booking['payment_status'] == 'unpaid') ? 'selected' : ''; ?>>Chưa thanh toán</option>
                                <option value="paid" <?php echo (isset($booking['payment_status']) && $booking['payment_status'] == 'paid') ? 'selected' : ''; ?>>Đã thanh toán</option>
                            </select>
                        </div>

                        <!-- Số chỗ tối đa -->
                        <div class="form-group">
                            <label for="max_people">Số chỗ tối đa <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="max_people" name="max_people"
                                value="<?php echo isset($booking['max_people']) ? $booking['max_people'] : 30; ?>"
                                placeholder="Nhập số chỗ tối đa" min="1" max="999" required>
                            <small class="form-text text-muted">
                                <i class="fa fa-info-circle"></i> Giới hạn số người tối đa có thể tham gia tour này
                            </small>
                        </div>

                        <!-- ✅ HIỂN THỊ THÔNG TIN CHỖ TRỐNG -->
                        <?php if (isset($seatInfo)): ?>
                            <div class="alert <?= $seatInfo['available_seats'] > 0 ? 'alert-success' : 'alert-danger' ?>"
                                style="margin-bottom: 20px; border-radius: 5px;">
                                <h4 style="margin-top: 0;">
                                    <i class="fa fa-users"></i> Thông tin chỗ ngồi
                                </h4>
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Tổng số chỗ:</strong>
                                        <span class="badge" style="font-size: 14px; background-color: #337ab7;">
                                            <?= $seatInfo['max_people'] ?> chỗ
                                        </span>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Đã đặt:</strong>
                                        <span class="badge" style="font-size: 14px; background-color: #f0ad4e;">
                                            <?= $seatInfo['current_people'] ?> người
                                        </span>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Còn trống:</strong>
                                        <span class="badge" style="font-size: 14px; background-color: <?= $seatInfo['available_seats'] > 0 ? '#5cb85c' : '#d9534f' ?>;">
                                            <?= $seatInfo['available_seats'] ?> chỗ
                                        </span>
                                    </div>
                                </div>
                                <?php if ($seatInfo['available_seats'] <= 0): ?>
                                    <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid rgba(255,255,255,0.3);">
                                        <i class="fa fa-exclamation-triangle"></i>
                                        <strong>Tour đã đầy!</strong> Không thể thêm người mới.
                                    </div>
                                <?php elseif ($seatInfo['available_seats'] <= 5): ?>
                                    <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid rgba(255,255,255,0.3);">
                                        <i class="fa fa-warning"></i>
                                        <strong>Sắp đầy!</strong> Chỉ còn <?= $seatInfo['available_seats'] ?> chỗ trống.
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <!-- PHƯƠNG TIỆN -->
                        <h4 class="text-success" style="margin-top: 30px; margin-bottom: 15px; border-bottom: 2px solid #5cb85c; padding-bottom: 10px;">
                            <i class="fa fa-bus"></i> Phương tiện di chuyển
                        </h4>

                        <div id="transports-container">
                            <?php
                            $transports = isset($booking['transports']) ? $booking['transports'] : [];
                            if (empty($transports)) {
                                $transports = [['type' => '', 'seats' => '', 'company' => '']];
                            }
                            foreach ($transports as $index => $transport):
                            ?>
                                <div class="transport-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f9f9f9;">
                                    <?php if (isset($transport['id']) && !empty($transport['id'])): ?>
                                        <input type="hidden" name="transports[<?= $index ?>][id]" value="<?= $transport['id'] ?>">
                                    <?php endif; ?>
                                    <h5 style="margin-top: 0;">Phương tiện #<?= $index + 1 ?></h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Loại phương tiện</label>
                                                <input type="text" class="form-control" name="transports[<?= $index ?>][type]"
                                                    value="<?= isset($transport['type']) ? htmlspecialchars($transport['type']) : '' ?>"
                                                    placeholder="VD: Xe du lịch 45 chỗ">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Số chỗ</label>
                                                <input type="number" class="form-control" name="transports[<?= $index ?>][seats]"
                                                    value="<?= isset($transport['seats']) ? $transport['seats'] : '' ?>"
                                                    placeholder="45">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Công ty</label>
                                                <input type="text" class="form-control" name="transports[<?= $index ?>][company]"
                                                    value="<?= isset($transport['company']) ? htmlspecialchars($transport['company']) : '' ?>"
                                                    placeholder="VD: Hoàng Long Travel">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <label>&nbsp;</label>
                                            <button type="button" class="btn btn-danger btn-sm form-control remove-transport" <?= $index == 0 ? 'style="display:none;"' : '' ?>>
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-success btn-sm" id="add-transport">
                            <i class="fa fa-plus"></i> Thêm phương tiện
                        </button>

                        <!-- KHÁCH SẠN -->
                        <h4 class="text-warning" style="margin-top: 30px; margin-bottom: 15px; border-bottom: 2px solid #f0ad4e; padding-bottom: 10px;">
                            <i class="fa fa-hotel"></i> Khách sạn / Nơi lưu trú
                        </h4>

                        <div id="accommodations-container">
                            <?php
                            $accommodations = isset($booking['accommodations']) ? $booking['accommodations'] : [];
                            if (empty($accommodations)) {
                                $accommodations = [['name' => '', 'type' => '', 'address' => '']];
                            }
                            foreach ($accommodations as $index => $accommodation):
                            ?>
                                <div class="accommodation-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #fffbf0;">
                                    <?php if (isset($accommodation['id']) && !empty($accommodation['id'])): ?>
                                        <input type="hidden" name="accommodations[<?= $index ?>][id]" value="<?= $accommodation['id'] ?>">
                                    <?php endif; ?>
                                    <h5 style="margin-top: 0;">Khách sạn #<?= $index + 1 ?></h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Tên khách sạn</label>
                                                <input type="text" class="form-control" name="accommodations[<?= $index ?>][name]"
                                                    value="<?= isset($accommodation['name']) ? htmlspecialchars($accommodation['name']) : '' ?>"
                                                    placeholder="VD: Hạ Long Bay Resort">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Loại</label>
                                                <select class="form-control" name="accommodations[<?= $index ?>][type]">
                                                    <option value="">Chọn loại</option>
                                                    <option value="Hotel" <?= (isset($accommodation['type']) && $accommodation['type'] == 'Hotel') ? 'selected' : '' ?>>Hotel</option>
                                                    <option value="Resort" <?= (isset($accommodation['type']) && $accommodation['type'] == 'Resort') ? 'selected' : '' ?>>Resort</option>
                                                    <option value="Homestay" <?= (isset($accommodation['type']) && $accommodation['type'] == 'Homestay') ? 'selected' : '' ?>>Homestay</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Địa chỉ</label>
                                                <input type="text" class="form-control" name="accommodations[<?= $index ?>][address]"
                                                    value="<?= isset($accommodation['address']) ? htmlspecialchars($accommodation['address']) : '' ?>"
                                                    placeholder="VD: Bãi Cháy, Quảng Ninh">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <label>&nbsp;</label>
                                            <button type="button" class="btn btn-danger btn-sm form-control remove-accommodation" <?= $index == 0 ? 'style="display:none;"' : '' ?>>
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-warning btn-sm" id="add-accommodation">
                            <i class="fa fa-plus"></i> Thêm khách sạn
                        </button>

                        <!-- LỊCH TRÌNH -->
                        <h4 class="text-info" style="margin-top: 30px; margin-bottom: 15px; border-bottom: 2px solid #5bc0de; padding-bottom: 10px;">
                            <i class="fa fa-calendar"></i> Lịch trình chi tiết
                        </h4>

                        <div id="schedules-container">
                            <?php
                            $schedules = isset($booking['schedules']) ? $booking['schedules'] : [];
                            if (empty($schedules)) {
                                $schedules = [['day_number' => 1, 'date' => '', 'location' => '', 'activities' => '', 'notes' => '']];
                            }
                            foreach ($schedules as $index => $schedule):
                            ?>
                                <div class="schedule-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f0f8ff;">
                                    <?php if (isset($schedule['id']) && !empty($schedule['id'])): ?>
                                        <input type="hidden" name="schedules[<?= $index ?>][id]" value="<?= $schedule['id'] ?>">
                                    <?php endif; ?>
                                    <h5 style="margin-top: 0;">Ngày <?= isset($schedule['day_number']) ? $schedule['day_number'] : ($index + 1) ?></h5>
                                    <input type="hidden" name="schedules[<?= $index ?>][day_number]" value="<?= $index + 1 ?>">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Ngày</label>
                                                <input type="date" class="form-control" name="schedules[<?= $index ?>][date]"
                                                    value="<?= isset($schedule['date']) ? $schedule['date'] : '' ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Địa điểm</label>
                                                <input type="text" class="form-control" name="schedules[<?= $index ?>][location]"
                                                    value="<?= isset($schedule['location']) ? htmlspecialchars($schedule['location']) : '' ?>"
                                                    placeholder="VD: Hà Nội - Hạ Long" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Hoạt động</label>
                                                <textarea class="form-control" name="schedules[<?= $index ?>][activities]" rows="2"
                                                    placeholder="Mô tả hoạt động trong ngày" disabled><?= isset($schedule['activities']) ? htmlspecialchars($schedule['activities']) : '' ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Ghi chú</label>
                                        <input type="text" class="form-control" name="schedules[<?= $index ?>][notes]"
                                            value="<?= isset($schedule['notes']) ? htmlspecialchars($schedule['notes']) : '' ?>"
                                            placeholder="VD: Mang theo CMND/CCCD" disabled>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Khách hàng -->
                        <h4 class="text-info" style="margin-top: 30px; margin-bottom: 15px; border-bottom: 2px solid #5bc0de; padding-bottom: 10px;">
                            <i class="fa fa-users"></i> Danh sách khách hàng tham gia
                            <small class="text-muted" style="font-size: 12px; font-weight: normal;">
                                (Chọn từ database hoặc thêm mới)
                            </small>
                        </h4>

                        <div id="people-container">
                            <?php
                            $peoples = isset($booking['people']) ? $booking['people'] : [];
                            if (empty($peoples)) {
                                $peoples = [['fullname' => '', 'date' => '', 'phone' => '', 'cccd' => '']];
                            }
                            foreach ($peoples as $index => $people):
                            ?>
                                <div class="people-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f0f8ff;">
                                    <h5 style="margin-top: 0; display: flex; align-items: center; justify-content: space-between;">
                                        <span>
                                            Khách hàng #<?= $index + 1 ?>
                                            <span class="badge person-type-badge" style="background-color: #5cb85c; margin-left: 10px; font-size: 11px;">
                                                <?= !empty($people['id']) ? 'Đã có trong hệ thống' : 'Thêm mới' ?>
                                            </span>
                                        </span>
                                        <button type="button" class="btn btn-danger btn-sm remove-people"
                                            <?= $index == 0 ? 'style="display:none;"' : '' ?>>
                                            <i class="fa fa-trash"></i> Xóa
                                        </button>
                                    </h5>

                                    <!-- Hidden ID (nếu đã có trong booking) -->
                                    <?php if (isset($people['id']) && !empty($people['id'])): ?>
                                        <input type="hidden" name="peoples[<?= $index ?>][id]" value="<?= $people['id'] ?>">
                                    <?php endif; ?>

                                    <!-- Dropdown chọn người có sẵn -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>
                                                    <i class="fa fa-database"></i> Chọn từ danh sách có sẵn
                                                    <small class="text-muted">(Chỉ hiện những người không trùng lịch)</small>
                                                </label>
                                                <select class="form-control person-selector"
                                                    name="peoples[<?= $index ?>][existing_id]"
                                                    data-index="<?= $index ?>"
                                                    style="font-weight: 500;">
                                                    <option value="new">➕ Thêm người mới (nhập thông tin bên dưới)</option>

                                                    <?php
                                                    // ✅ RENDER SẴN DANH SÁCH NGƯỜI
                                                    if (isset($availablePeople) && !empty($availablePeople)):
                                                        foreach ($availablePeople as $person):
                                                    ?>
                                                            <option value="<?= $person['id'] ?>"
                                                                data-fullname="<?= htmlspecialchars($person['fullname']) ?>"
                                                                data-phone="<?= htmlspecialchars($person['phone'] ?? '') ?>"
                                                                data-date="<?= htmlspecialchars($person['date'] ?? '') ?>"
                                                                data-cccd="<?= htmlspecialchars($person['cccd'] ?? '') ?>">
                                                                <?= htmlspecialchars($person['fullname']) ?> -
                                                                <?= htmlspecialchars($person['phone'] ?? 'N/A') ?> -
                                                                <?= htmlspecialchars($person['date'] ?? 'N/A') ?>
                                                                (<?= $person['total_bookings'] ?? 0 ?> tour)
                                                            </option>
                                                    <?php
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </select>

                                                <?php if (empty($availablePeople)): ?>
                                                    <small class="text-warning" style="display: block; margin-top: 5px;">
                                                        <i class="fa fa-exclamation-triangle"></i>
                                                        Không có người nào khả dụng trong thời gian này
                                                    </small>
                                                <?php else: ?>
                                                    <small class="text-success" style="display: block; margin-top: 5px;">
                                                        <i class="fa fa-check-circle"></i>
                                                        Tìm thấy <?= count($availablePeople) ?> người khả dụng
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Form nhập thông tin (hiện khi chọn "Thêm mới") -->
                                    <div class="person-form-fields">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Họ và tên <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control person-fullname"
                                                        name="peoples[<?= $index ?>][fullname]"
                                                        value="<?= isset($people['fullname']) ? htmlspecialchars($people['fullname']) : '' ?>"
                                                        placeholder="Nguyễn Văn A">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Ngày sinh <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control person-date"
                                                        name="peoples[<?= $index ?>][date]"
                                                        value="<?= isset($people['date']) ? $people['date'] : '' ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Số điện thoại <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control person-phone"
                                                        name="peoples[<?= $index ?>][phone]"
                                                        value="<?= isset($people['phone']) ? htmlspecialchars($people['phone']) : '' ?>"
                                                        placeholder="0987654321">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>CCCD/CMND <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control person-cccd"
                                                        name="peoples[<?= $index ?>][cccd]"
                                                        value="<?= isset($people['cccd']) ? htmlspecialchars($people['cccd']) : '' ?>"
                                                        placeholder="001234567890">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <button type="button" class="btn btn-info btn-sm" id="add-people" style="margin-top: 10px;">
                            <i class="fa fa-plus"></i> Thêm khách hàng
                        </button>

                        <!-- Buttons -->
                        <div class="form-group" style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #ddd;">
                            <button type="submit" class="btn btn-primary" name="submit">
                                <i class="fa fa-save"></i> Cập nhật Tour
                            </button>
                            <a href="index.php?act=QlTour" class="btn btn-default">
                                <i class="fa fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    (function() {
        'use strict';

        console.log('🚀 Script khởi động...');

        // Kiểm tra trang
        const peopleContainer = document.getElementById('people-container');
        if (!peopleContainer) {
            console.log('⏭️ Không phải trang booking-edit');
            return;
        }

        let peopleCount = document.querySelectorAll('.people-item').length;

        // ==========================================
        // EVENT: CHỌN NGƯỜI TỪ DROPDOWN
        // ==========================================
        document.addEventListener('change', function(e) {
            if (!e.target.classList.contains('person-selector')) return;

            const select = e.target;
            const peopleItem = select.closest('.people-item');
            if (!peopleItem) return;

            const formFields = peopleItem.querySelector('.person-form-fields');
            const typeBadge = peopleItem.querySelector('.person-type-badge');

            if (select.value === 'new') {
                // Chọn "Thêm mới"
                formFields.style.display = 'block';
                typeBadge.textContent = 'Thêm mới';
                typeBadge.style.backgroundColor = '#5cb85c';

                // Xóa dữ liệu cũ
                peopleItem.querySelector('.person-fullname').value = '';
                peopleItem.querySelector('.person-phone').value = '';
                peopleItem.querySelector('.person-date').value = '';
                peopleItem.querySelector('.person-cccd').value = '';

                // Bật input
                toggleFields(peopleItem, false);
            } else {
                // Chọn người có sẵn
                const opt = select.options[select.selectedIndex];

                // Điền dữ liệu từ data-*
                peopleItem.querySelector('.person-fullname').value = opt.dataset.fullname || '';
                peopleItem.querySelector('.person-phone').value = opt.dataset.phone || '';
                peopleItem.querySelector('.person-date').value = opt.dataset.date || '';
                peopleItem.querySelector('.person-cccd').value = opt.dataset.cccd || '';

                // Ẩn form
                formFields.style.display = 'none';
                typeBadge.textContent = 'Từ database';
                typeBadge.style.backgroundColor = '#f0ad4e';

                // Khóa input
                toggleFields(peopleItem, true);
            }
        });

        function toggleFields(peopleItem, disabled) {
            const fields = peopleItem.querySelectorAll('.person-fullname, .person-phone, .person-date, .person-cccd');
            fields.forEach(field => {
                field.disabled = disabled;
                field.required = !disabled;
            });
        }

        // ==========================================
        // EVENT: THÊM NGƯỜI MỚI
        // ==========================================
        const addBtn = document.getElementById('add-people');
        if (addBtn) {
            addBtn.addEventListener('click', function() {
                const maxPeople = parseInt(document.getElementById('max_people')?.value) || 30;
                const currentPeople = document.querySelectorAll('.people-item').length;

                if (currentPeople >= maxPeople) {
                    alert(`⚠️ Đã đạt giới hạn ${maxPeople} người!`);
                    return;
                }

                // Clone dropdown options từ dropdown đầu tiên
                const firstSelect = document.querySelector('.person-selector');
                let optionsHtml = '';
                if (firstSelect) {
                    Array.from(firstSelect.options).forEach(opt => {
                        optionsHtml += `<option value="${opt.value}"
                        data-fullname="${opt.dataset.fullname || ''}"
                        data-phone="${opt.dataset.phone || ''}"
                        data-date="${opt.dataset.date || ''}"
                        data-cccd="${opt.dataset.cccd || ''}">${opt.textContent}</option>`;
                    });
                } else {
                    optionsHtml = '<option value="new">➕ Thêm mới</option>';
                }

                const html = `
            <div class="people-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f0f8ff;">
                <h5 style="margin-top: 0; display: flex; justify-content: space-between;">
                    <span>
                        Khách hàng #${peopleCount + 1}
                        <span class="badge person-type-badge" style="background-color: #5cb85c; margin-left: 10px; font-size: 11px;">Thêm mới</span>
                    </span>
                    <button type="button" class="btn btn-danger btn-sm remove-people">
                        <i class="fa fa-trash"></i> Xóa
                    </button>
                </h5>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><i class="fa fa-database"></i> Chọn từ danh sách</label>
                            <select class="form-control person-selector" name="peoples[${peopleCount}][existing_id]" data-index="${peopleCount}">
                                ${optionsHtml}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="person-form-fields">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Họ tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control person-fullname" name="peoples[${peopleCount}][fullname]" placeholder="Nguyễn Văn A" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Ngày sinh <span class="text-danger">*</span></label>
                                <input type="date" class="form-control person-date" name="peoples[${peopleCount}][date]" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>SĐT <span class="text-danger">*</span></label>
                                <input type="text" class="form-control person-phone" name="peoples[${peopleCount}][phone]" placeholder="0987654321" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>CCCD <span class="text-danger">*</span></label>
                                <input type="text" class="form-control person-cccd" name="peoples[${peopleCount}][cccd]" placeholder="001234567890" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `;

                peopleContainer.insertAdjacentHTML('beforeend', html);
                peopleCount++;
            });
        }

        // ==========================================
        // EVENT: XÓA NGƯỜI
        // ==========================================
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-people') || e.target.closest('.remove-people')) {
                const item = e.target.closest('.people-item');
                if (item && confirm('⚠️ Xác nhận xóa?')) {
                    item.remove();
                }
            }
        });

        // ==========================================
        // EVENT: THAY ĐỔI NGÀY → RELOAD TRANG
        // ==========================================
        const startDateEl = document.getElementById('start_date');
        const endDateEl = document.getElementById('end_date');

        if (startDateEl && endDateEl) {
            let dateChangeTimeout;

            function handleDateChange() {
                clearTimeout(dateChangeTimeout);
                dateChangeTimeout = setTimeout(() => {
                    const startDate = startDateEl.value;
                    const endDate = endDateEl.value;

                    if (startDate && endDate) {
                        const url = new URL(window.location.href);
                        const bookingId = url.searchParams.get('id');

                        if (confirm('🔄 Ngày đã thay đổi. Reload trang để cập nhật danh sách người?')) {
                            // Reload trang để PHP render lại
                            window.location.reload();
                        }
                    }
                }, 500);
            }

            startDateEl.addEventListener('change', handleDateChange);
            endDateEl.addEventListener('change', handleDateChange);
        }

        console.log('✅ Script loaded successfully');
    })();
</script>
<style>
    .person-selector {
        font-weight: 500;
        border: 2px solid #5bc0de;
    }

    .person-selector:focus {
        border-color: #46b8da;
        box-shadow: 0 0 5px rgba(70, 184, 218, 0.5);
    }

    .person-form-fields {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 2px dashed #5bc0de;
    }

    .person-type-badge {
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 3px;
    }

    .people-item {
        transition: all 0.3s ease;
    }

    .people-item:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    input:disabled,
    select:disabled {
        background-color: #e9ecef !important;
        cursor: not-allowed;
    }

    #add-people:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
</style>
<?php
require_once __DIR__ . '/../../layout/admin/footer.php';
