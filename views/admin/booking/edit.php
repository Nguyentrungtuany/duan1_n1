<?php
require_once __DIR__ . '/../../layout/admin/header.php';
// echo json_encode($booking, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
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
                        <!-- <div class="form-group">
                            <label for="category_id">Danh mục <span class="text-danger">*</span></label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="">-- Chọn danh mục --</option>

                                <?php foreach ($allCategory as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>"
                                        <?php echo (isset($booking['category_id']) && $booking['category_id'] == $cat['id']) ? 'selected' : ''; ?>>
                                        <?php echo $cat['name']; ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </div> -->
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

                        <!-- Điểm đến -->


                        <div class="form-group">
                            <label for="tour_id">Điểm đến <span class="text-danger">*</span></label>
                            <select class="form-control" id="tour_id" name="tour_id" required>
                                <option value="">-- Chọn điểm đến --</option>
                                <?php foreach ($allTour as $tour): ?>
                                    <option value="<?= $tour['id'] ?>"
                                        <?= (isset($booking['tour_id']) && $booking['tour_id'] == $tour['id']) ? 'selected' : '' ?>

                                        data-name="<?= htmlspecialchars($tour['name']) ?>"
                                        data-price="<?= $tour['price'] ?>"
                                        data-description="<?= htmlspecialchars($tour['description'] ?? '') ?>"
                                        data-category="<?= $tour['category_id'] ?>"
                                        data-start="<?= $tour['start_date'] ?? '' ?>"
                                        data-end="<?= $tour['end_date'] ?? '' ?>">
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
                        <!--yêu cầu -->
                        <div class="form-group">
                            <label for="special_request">yêu cầu <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="special_request" name="special_request" rows="4"
                                placeholder="Nhập mô tả tour"><?php echo isset($booking['special_request']) ? htmlspecialchars($booking['special_request']) : ''; ?></textarea>
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
                                <option value="pending " <?php echo (isset($booking['status']) && $booking['status'] == 'pending ') ? 'selected' : ''; ?>>Đang chờ xử lý</option>
                                <option value="confirmed " <?php echo (isset($booking['status']) && $booking['status'] == 'confirmed ') ? 'selected' : ''; ?>>Đã xử lý</option>
                                <option value="cancelled " <?php echo (isset($booking['status']) && $booking['status'] == 'cancelled ') ? 'selected' : ''; ?>>Đ</option>
                                <option value="full" <?php echo (isset($booking['status']) && $booking['status'] == 'full') ? 'selected' : ''; ?>>Đã đầy</option>
                            </select>
                        </div>
                        <!-- chuyển tiền -->
                        <div class="form-group">
                            <label for="payment_status">Chuyển tiền</label>
                            <select class="form-control" id="payment_status" name="payment_status">
                                <option value="unpaid " <?php echo (isset($booking['payment_status']) && $booking['payment_status'] == 'unpaid') ? 'selected' : ''; ?>>Chưa chuyển tiền</option>
                                <option value="paid " <?php echo (isset($booking['payment_status']) && $booking['payment_status'] == 'paid ') ? 'selected' : ''; ?>>Đã chuyển tiền</option>

                            </select>
                        </div>
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
                                    <!-- SỬA: Đổi tên field để không ghi đè array -->
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
                                                    value="<?= isset($schedule['date']) ? $schedule['date'] : '' ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Địa điểm</label>
                                                <input type="text" class="form-control" name="schedules[<?= $index ?>][location]"
                                                    value="<?= isset($schedule['location']) ? htmlspecialchars($schedule['location']) : '' ?>"
                                                    placeholder="VD: Hà Nội - Hạ Long">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Hoạt động</label>
                                                <textarea class="form-control" name="schedules[<?= $index ?>][activities]" rows="2"
                                                    placeholder="Mô tả hoạt động trong ngày"><?= isset($schedule['activities']) ? htmlspecialchars($schedule['activities']) : '' ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <label>&nbsp;</label>
                                            <button type="button" class="btn btn-danger btn-sm form-control remove-schedule" <?= $index == 0 ? 'style="display:none;"' : '' ?>>
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Ghi chú</label>
                                        <input type="text" class="form-control" name="schedules[<?= $index ?>][notes]"
                                            value="<?= isset($schedule['notes']) ? htmlspecialchars($schedule['notes']) : '' ?>"
                                            placeholder="VD: Mang theo CMND/CCCD">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-info btn-sm" id="add-schedule">
                            <i class="fa fa-plus"></i> Thêm ngày
                        </button>
                        <!-- Khách hàng -->
                        <h4 class="text-info" style="margin-top: 30px; margin-bottom: 15px; border-bottom: 2px solid #5bc0de; padding-bottom: 10px;">
                            <i class="fa fa-calendar"></i> Khách hàng
                        </h4>

                        <div id="people-container">
                            <?php
                            $peoples = isset($booking['people']) ? $booking['people'] : [];
                            if (empty($peoples)) {
                                $peoples = [['day_number' => 1, 'date' => '', 'location' => '', 'activities' => '', 'notes' => '']];
                            }
                            foreach ($peoples as $index => $people):
                            ?>
                                <div class="people-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f0f8ff;">
                                    <!-- SỬA: Đổi tên field để không ghi đè array -->
                                    <?php if (isset($peoples['id']) && !empty($people['id'])): ?>
                                        <input type="hidden" name="peoples[<?= $index ?>][id]" value="<?= $people['id'] ?>">
                                    <?php endif; ?>
                                    <input type="hidden" name="peoples[<?= $index ?>][id]" value="<?= $index + 1 ?>">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Tên</label>
                                                <input type="text" class="form-control" name="peoples[<?= $index ?>][fullname]"
                                                    value="<?= isset($people['fullname']) ? $people['fullname'] : '' ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Ngày sinh</label>
                                                <input type="date" class="form-control" name="peoples[<?= $index ?>][date]"
                                                    value="<?= isset($people['date']) ? htmlspecialchars($people['date']) : '' ?>"
                                                    placeholder="VD: 2000-01-01">
                                            </div>
                                        </div>
                                        <<div class="col-md-3">
                                            <div class="form-group">
                                                <label>Số điện thoại</label>
                                                <input type="text" class="form-control" name="peoples[<?= $index ?>][phone]"
                                                    value="<?= isset($people['phone']) ? htmlspecialchars($people['phone']) : '' ?>"
                                                    placeholder="VD: 0987654321">
                                            </div>
                                    </div>
                                    <div class="col-md-1">
                                        <label>&nbsp;</label>
                                        <button type="button" class="btn btn-danger btn-sm form-control remove-people" <?= $index == 0 ? 'style="display:none;"' : '' ?>>
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>

                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="btn btn-info btn-sm" id="add-people">
                    <i class="fa fa-plus"></i> Thêm Khách hàng
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
    // Đếm số lượng hiện tại
    let transportCount = <?= count($transports) ?>;
    let accommodationCount = <?= count($accommodations) ?>;
    let scheduleCount = <?= count($schedules) ?>;
    let peopleCount = <?= count($peoples) ?>;
    // ===== AUTO-FILL KHI CHỌN TOUR =====
    document.getElementById('tour_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];

        if (selectedOption.value) {
            // Lấy data attributes
            const tourName = selectedOption.getAttribute('data-name');
            const price = selectedOption.getAttribute('data-price');
            const description = selectedOption.getAttribute('data-description');
            const categoryId = selectedOption.getAttribute('data-category');
            const startDate = selectedOption.getAttribute('data-start');
            const endDate = selectedOption.getAttribute('data-end');

            // Tự động điền vào các trường
            if (tourName) {
                document.getElementById('name').value = tourName;
            }

            if (price) {
                document.getElementById('price').value = price;
            }

            if (description) {
                document.getElementById('description').value = description;
            }

            if (categoryId) {
                document.getElementById('category_id').value = categoryId;
            }

            if (startDate) {
                document.getElementById('start_date').value = startDate;
            }

            if (endDate) {
                document.getElementById('end_date').value = endDate;
            }

            // Hiển thị thông báo
            console.log('Đã tự động điền thông tin tour');
        } else {
            // Xóa dữ liệu nếu bỏ chọn
            document.getElementById('name').value = '';
            document.getElementById('price').value = '';
            document.getElementById('description').value = '';
        }
    });

    // Validation ngày
    document.getElementById('start_date').addEventListener('change', function() {
        const endDate = document.getElementById('end_date');
        endDate.min = this.value;
    });
    // Thêm phương tiện
    document.getElementById('add-transport').addEventListener('click', function() {
        const container = document.getElementById('transports-container');
        const newItem = `
        <div class="transport-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f9f9f9;">
            <h5 style="margin-top: 0;">Phương tiện #${transportCount + 1}</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Loại phương tiện</label>
                        <input type="text" class="form-control" name="transports[${transportCount}][type]" placeholder="VD: Xe du lịch 45 chỗ">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Số chỗ</label>
                        <input type="number" class="form-control" name="transports[${transportCount}][seats]" placeholder="45">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Công ty</label>
                        <input type="text" class="form-control" name="transports[${transportCount}][company]" placeholder="VD: Hoàng Long Travel">
                    </div>
                </div>
                <div class="col-md-1">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-danger btn-sm form-control remove-transport">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
        container.insertAdjacentHTML('beforeend', newItem);
        transportCount++;
    });

    // Xóa phương tiện
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-transport')) {
            e.target.closest('.transport-item').remove();
        }
    });

    // Thêm khách sạn
    document.getElementById('add-accommodation').addEventListener('click', function() {
        const container = document.getElementById('accommodations-container');
        const newItem = `
        <div class="accommodation-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #fffbf0;">
            <h5 style="margin-top: 0;">Khách sạn #${accommodationCount + 1}</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tên khách sạn</label>
                        <input type="text" class="form-control" name="accommodations[${accommodationCount}][name]" placeholder="VD: Hạ Long Bay Resort">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Loại</label>
                        <select class="form-control" name="accommodations[${accommodationCount}][type]">
                            <option value="">Chọn loại</option>
                            <option value="Hotel">Hotel</option>
                            <option value="Resort">Resort</option>
                            <option value="Homestay">Homestay</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <input type="text" class="form-control" name="accommodations[${accommodationCount}][address]" placeholder="VD: Bãi Cháy, Quảng Ninh">
                    </div>
                </div>
                <div class="col-md-1">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-danger btn-sm form-control remove-accommodation">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
        container.insertAdjacentHTML('beforeend', newItem);
        accommodationCount++;
    });

    // Xóa khách sạn
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-accommodation')) {
            e.target.closest('.accommodation-item').remove();
        }
    });

    // Thêm lịch trình
    document.getElementById('add-schedule').addEventListener('click', function() {
        const container = document.getElementById('schedules-container');
        const newItem = `
        <div class="schedule-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f0f8ff;">
            <h5 style="margin-top: 0;">Ngày ${scheduleCount + 1}</h5>
            <input type="hidden" name="schedules[${scheduleCount}][day_number]" value="${scheduleCount + 1}">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Ngày</label>
                        <input type="date" class="form-control" name="schedules[${scheduleCount}][date]">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Địa điểm</label>
                        <input type="text" class="form-control" name="schedules[${scheduleCount}][location]" placeholder="VD: Hà Nội - Hạ Long">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Hoạt động</label>
                        <textarea class="form-control" name="schedules[${scheduleCount}][activities]" rows="2" placeholder="Mô tả hoạt động trong ngày"></textarea>
                    </div>
                </div>
                <div class="col-md-1">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-danger btn-sm form-control remove-schedule">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
            <div class="form-group">
                <label>Ghi chú</label>
                <input type="text" class="form-control" name="schedules[${scheduleCount}][notes]" placeholder="VD: Mang theo CMND/CCCD">
            </div>
        </div>
    `;
        container.insertAdjacentHTML('beforeend', newItem);
        scheduleCount++;
    });

    // Xóa lịch trình
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-schedule')) {
            e.target.closest('.schedule-item').remove();
        }
    });


    // Thêm khách hàng
    document.getElementById('add-people').addEventListener('click', function() {
        const container = document.getElementById('people-container');
        const newItem = `
         <div class="people-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f0f8ff;">
            <div class="row">
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tên</label>
                        <input type="text" class="form-control" name="peoples[${peopleCount}][fullname]" placeholder="Họ tên">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Ngày sinh</label>
                        <input type="date" class="form-control" name="peoples[${peopleCount}][date]" placeholder="2000-01-01">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" class="form-control" name="peoples[${peopleCount}][phone]" placeholder="0987654321">
                    </div>
                </div>

                <div class="col-md-1">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-danger btn-sm form-control remove-schedule">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>

            </div>
        </div>
    `;
        container.insertAdjacentHTML('beforeend', newItem);
        scheduleCount++;
    });

    // Xóa khách hàng
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-people')) {
            e.target.closest('.people-item').remove();
        }
    });
</script>
<style>
    html,
    body {
        overflow: auto !important;
        height: auto !important;
        max-height: none !important;
    }
</style>
<?php
require_once __DIR__ . '/../../layout/admin/footer.php';
