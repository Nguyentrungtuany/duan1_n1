<?php
require_once __DIR__ . '/../../layout/admin/header.php';
?>

<!-- main content start-->
<div id="page-wrapper">
    <div class="main-page">
        <div class="forms">
            <h2 class="title1">Thêm booking mới</h2>
            <div class="form-grids row widget-shadow" data-example-id="basic-forms">
                <div class="form-title">
                    <h4>Form tạo booking mới</h4>
                </div>
                <div class="form-body">
                    <form method="POST" action="<?php echo BASE_URL; ?>index.php?act=bookings-create" enctype="multipart/form-data">

                        <h4 class="text-primary" style="margin-top: 20px; margin-bottom: 15px; border-bottom: 2px solid #337ab7; padding-bottom: 10px;">
                            <i class="fa fa-info-circle"></i> Thông tin cơ bản
                        </h4>

                        <!-- Tên Tour -->
                        <div class="form-group">
                            <label for="name">Tên Tour <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Nhập tên tour" disabled>
                        </div>

                        <!-- Danh mục -->
                        <div class="form-group">
                            <label for="category_id">Danh mục <span class="text-danger">*</span></label>
                            <select class="form-control" id="category_id" name="category_id" disabled>
                                <option value="">-- Chọn danh mục --</option>
                                <?php foreach ($allCategory as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>">
                                        <?php echo htmlspecialchars($cat['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Hướng Dẫn Viên -->
                        <div class="form-group">
                            <label for="guide_id">Hướng Dẫn Viên <span class="text-danger">*</span></label>
                            <select class="form-control" id="guide_id" name="guide_id" required>
                                <option value="">-- Chọn Hướng Dẫn Viên --</option>
                                <?php foreach ($allGuide as $gui): ?>
                                    <option value="<?= $gui['id'] ?>">
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
                                    // Lấy schedules của tour
                                    $tourSchedules = [];
                                    if (isset($tour['schedules'])) {
                                        $tourSchedules = is_string($tour['schedules'])
                                            ? json_decode($tour['schedules'], true)
                                            : $tour['schedules'];
                                    }
                                ?>
                                    <option value="<?= $tour['id'] ?>"
                                        data-name="<?= htmlspecialchars($tour['name']) ?>"
                                        data-price="<?= $tour['price'] ?>"
                                        data-description="<?= htmlspecialchars($tour['description'] ?? '') ?>"
                                        data-category="<?= $tour['category_id'] ?>"
                                        data-schedules='<?= htmlspecialchars(json_encode($tourSchedules ?: []), ENT_QUOTES, 'UTF-8') ?>'>
                                        <?= htmlspecialchars($tour['name']) ?> - <?= number_format($tour['price']) ?> VNĐ
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- Mô tả -->
                        <div class="form-group">
                            <label for="description">Mô tả <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="4"
                                placeholder="Nhập mô tả tour"></textarea>
                        </div>

                        <!-- Yêu cầu đặc biệt -->
                        <div class="form-group">
                            <label for="special_request">Yêu cầu đặc biệt</label>
                            <textarea class="form-control" id="special_request" name="special_request" rows="4"
                                placeholder="Nhập yêu cầu đặc biệt"></textarea>
                        </div>

                        <!-- Ngày bắt đầu và Ngày kết thúc -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date">Ngày bắt đầu <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="start_date" name="start_date">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_date">Ngày kết thúc <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="end_date" name="end_date">
                                </div>
                            </div>
                        </div>

                        <!-- Giá -->
                        <div class="form-group">
                            <label for="price">Giá (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="price" name="price"
                                placeholder="Nhập giá tour" min="0" disabled>
                        </div>

                        <!-- Trạng thái -->
                        <div class="form-group">
                            <label for="status">Trạng thái</label>
                            <select class="form-control" id="status" name="status">
                                <option value="pending" selected>Đang chờ xử lý</option>
                                <option value="confirmed">Đã xác nhận</option>
                                <option value="cancelled">Đã hủy</option>
                                <option value="completed">Hoàn thành</option>
                            </select>
                        </div>

                        <!-- Số chỗ tối đa -->
                        <div class="form-group">
                            <label for="max_people">Số chỗ tối đa <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="max_people" name="max_people"
                                placeholder="Nhập số chỗ tối đa (VD: 30)" min="1" max="999" required>
                            <small class="form-text text-muted">
                                <i class="fa fa-info-circle"></i> Giới hạn số người tối đa có thể tham gia tour này
                            </small>
                        </div>

                        <!-- PHƯƠNG TIỆN -->
                        <h4 class="text-success" style="margin-top: 30px; margin-bottom: 15px; border-bottom: 2px solid #5cb85c; padding-bottom: 10px;">
                            <i class="fa fa-bus"></i> Phương tiện di chuyển
                        </h4>

                        <div id="transports-container">
                            <div class="transport-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f9f9f9;">
                                <h5 style="margin-top: 0;">Phương tiện #1</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Loại phương tiện</label>
                                            <input type="text" class="form-control" name="transports[0][type]"
                                                placeholder="VD: Xe du lịch 45 chỗ">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Số chỗ</label>
                                            <input type="number" class="form-control" name="transports[0][seats]"
                                                placeholder="45">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Công ty</label>
                                            <input type="text" class="form-control" name="transports[0][company]"
                                                placeholder="VD: Hoàng Long Travel">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <label>&nbsp;</label>
                                        <button type="button" class="btn btn-danger btn-sm form-control remove-transport" style="display:none;">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success btn-sm" id="add-transport">
                            <i class="fa fa-plus"></i> Thêm phương tiện
                        </button>

                        <!-- KHÁCH SẠN -->
                        <h4 class="text-warning" style="margin-top: 30px; margin-bottom: 15px; border-bottom: 2px solid #f0ad4e; padding-bottom: 10px;">
                            <i class="fa fa-hotel"></i> Khách sạn / Nơi lưu trú
                        </h4>

                        <div id="accommodations-container">
                            <div class="accommodation-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #fffbf0;">
                                <h5 style="margin-top: 0;">Khách sạn #1</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Tên khách sạn</label>
                                            <input type="text" class="form-control" name="accommodations[0][name]"
                                                placeholder="VD: Hạ Long Bay Resort">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Loại</label>
                                            <select class="form-control" name="accommodations[0][type]">
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
                                            <input type="text" class="form-control" name="accommodations[0][address]"
                                                placeholder="VD: Bãi Cháy, Quảng Ninh">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <label>&nbsp;</label>
                                        <button type="button" class="btn btn-danger btn-sm form-control remove-accommodation" style="display:none;">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-warning btn-sm" id="add-accommodation">
                            <i class="fa fa-plus"></i> Thêm khách sạn
                        </button>

                        <!-- LỊCH TRÌNH -->
                        <h4 class="text-info" style="margin-top: 30px; margin-bottom: 15px; border-bottom: 2px solid #5bc0de; padding-bottom: 10px;">
                            <i class="fa fa-calendar"></i> Lịch trình chi tiết
                        </h4>

                        <div id="schedules-container">
                            <div class="schedule-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f0f8ff;">
                                <h5 style="margin-top: 0;">Ngày 1</h5>
                                <input type="hidden" name="schedules[0][day_number]" value="1">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Ngày</label>
                                            <input type="date" class="form-control" name="schedules[0][date]" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Địa điểm</label>
                                            <input type="text" class="form-control" name="schedules[0][location]"
                                                placeholder="VD: Hà Nội - Hạ Long" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Hoạt động</label>
                                            <textarea class="form-control" name="schedules[0][activities]" rows="2"
                                                placeholder="Mô tả hoạt động trong ngày" disabled></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <label>&nbsp;</label>
                                        <button type="button" class="btn btn-danger btn-sm form-control remove-schedule" style="display:none;">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Ghi chú</label>
                                    <input type="text" class="form-control" name="schedules[0][notes]"
                                        placeholder="VD: Mang theo CMND/CCCD" disabled>
                                </div>
                            </div>
                        </div>
                        <!-- KHÁCH HÀNG -->
                        <h4 class="text-info" style="margin-top: 30px; margin-bottom: 15px; border-bottom: 2px solid #5bc0de; padding-bottom: 10px;">
                            <i class="fa fa-users"></i> Danh sách khách hàng tham gia
                        </h4>

                        <div id="people-container">
                            <div class="people-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f0f8ff;">
                                <h5 style="margin-top: 0;">Khách hàng #1</h5>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Tên</label>
                                            <input type="text" class="form-control" name="peoples[0][fullname]"
                                                placeholder="Họ tên">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Ngày sinh</label>
                                            <input type="date" class="form-control" name="peoples[0][date]">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Số điện thoại</label>
                                            <input type="text" class="form-control" name="peoples[0][phone]"
                                                placeholder="0987654321">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>CCCD</label>
                                            <input type="text" class="form-control" name="peoples[0][cccd]"
                                                placeholder="123456789">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <label>&nbsp;</label>
                                        <button type="button" class="btn btn-danger btn-sm form-control remove-people" style="display:none;">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-info btn-sm" id="add-people">
                            <i class="fa fa-plus"></i> Thêm Khách hàng
                        </button>

                        <!-- Buttons -->
                        <div class="form-group" style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #ddd;">
                            <button type="submit" class="btn btn-primary" name="submit">
                                <i class="fa fa-save"></i> Tạo Booking
                            </button>
                            <a href="index.php?act=bookings" class="btn btn-default">
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
    // ===== KHỞI TẠO BIẾN ĐẾM =====
    let transportCount = document.querySelectorAll('.transport-item').length;
    let accommodationCount = document.querySelectorAll('.accommodation-item').length;
    let scheduleCount = document.querySelectorAll('.schedule-item').length;
    let peopleCount = document.querySelectorAll('.people-item').length;

    // ===== AUTO-FILL KHI CHỌN TOUR =====
    document.getElementById('tour_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];

        if (!selectedOption.value) {
            // Xóa dữ liệu nếu bỏ chọn
            document.getElementById('name').value = '';
            document.getElementById('price').value = '';
            document.getElementById('description').value = '';
            document.getElementById('start_date').value = '';
            document.getElementById('end_date').value = '';
            return;
        }

        // Lấy data attributes
        const tourData = {
            name: selectedOption.getAttribute('data-name'),
            price: selectedOption.getAttribute('data-price'),
            description: selectedOption.getAttribute('data-description'),
            category: selectedOption.getAttribute('data-category'),
            startDate: selectedOption.getAttribute('data-start'),
            endDate: selectedOption.getAttribute('data-end'),
            schedulesData: selectedOption.getAttribute('data-schedules')
        };

        // Tự động điền thông tin cơ bản
        if (tourData.name) document.getElementById('name').value = tourData.name;
        if (tourData.price) document.getElementById('price').value = tourData.price;
        if (tourData.description) document.getElementById('description').value = tourData.description;
        if (tourData.category) document.getElementById('category_id').value = tourData.category;
        if (tourData.startDate) document.getElementById('start_date').value = tourData.startDate;
        if (tourData.endDate) document.getElementById('end_date').value = tourData.endDate;

        // ✅ XỬ LÝ LỊCH TRÌNH TỰ ĐỘNG
        if (tourData.schedulesData && tourData.schedulesData !== 'null' && tourData.schedulesData !== '[]') {
            try {
                const schedules = JSON.parse(tourData.schedulesData);

                if (schedules && Array.isArray(schedules) && schedules.length > 0) {
                    updateSchedules(schedules);
                    console.log(`✅ Đã tự động điền ${schedules.length} lịch trình`);
                }
            } catch (e) {
                console.error('❌ Lỗi parse schedules:', e);
            }
        }
    });

    // ===== HÀM CẬP NHẬT LỊCH TRÌNH =====
    function updateSchedules(schedules) {
        const container = document.getElementById('schedules-container');
        container.innerHTML = '';

        schedules.forEach((schedule, index) => {
            const scheduleHTML = `
                <div class="schedule-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f0f8ff;">
                    <h5 style="margin-top: 0;">Ngày ${index + 1}</h5>
                    <input type="hidden" name="schedules[${index}][day_number]" value="${index + 1}">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Ngày</label>
                                <input type="date" class="form-control" name="schedules[${index}][date]" 
                                    value="${schedule.date || ''}" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Địa điểm</label>
                                <input type="text" class="form-control" name="schedules[${index}][location]" 
                                    value="${escapeHtml(schedule.location || '')}" 
                                    placeholder="VD: Hà Nội - Hạ Long" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Hoạt động</label>
                                <textarea class="form-control" name="schedules[${index}][activities]" rows="2" 
                                    placeholder="Mô tả hoạt động" disabled>${escapeHtml(schedule.activities || '')}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Ghi chú</label>
                        <input type="text" class="form-control" name="schedules[${index}][notes]" 
                            value="${escapeHtml(schedule.notes || '')}" 
                            placeholder="VD: Mang theo CMND/CCCD" disabled>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', scheduleHTML);
        });

        scheduleCount = schedules.length;
    }

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Validation ngày
    document.getElementById('start_date').addEventListener('change', function() {
        const endDate = document.getElementById('end_date');
        endDate.min = this.value;
    });

    // ===== PHƯƠNG TIỆN =====
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

    // ===== KHÁCH SẠN =====
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

    // ===== KHÁCH HÀNG =====
    document.getElementById('add-people').addEventListener('click', function() {
        const container = document.getElementById('people-container');
        const newItem = `
        <div class="people-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f0f8ff;">
            <h5 style="margin-top: 0;">Khách hàng #${peopleCount + 1}</h5>
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
                        <input type="date" class="form-control" name="peoples[${peopleCount}][date]">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" class="form-control" name="peoples[${peopleCount}][phone]" placeholder="0987654321">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>CCCD</label>
                        <input type="text" class="form-control" name="peoples[${peopleCount}][cccd]" placeholder="Nhập số CCCD">
                    </div>
                </div>
                <div class="col-md-1">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-danger btn-sm form-control remove-people">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
        container.insertAdjacentHTML('beforeend', newItem);
        peopleCount++;
    });

    document.addEventListener('click', function(e) {
        const target = e.target;

        // Xóa phương tiện
        if (target.classList.contains('remove-transport') || target.closest('.remove-transport')) {
            const item = target.closest('.transport-item');
            if (item) {
                item.remove();
                console.log('✅ Đã xóa phương tiện');
            }
        }

        if (target.classList.contains('remove-accommodation') || target.closest('.remove-accommodation')) {
            const item = target.closest('.accommodation-item');
            if (item) {
                item.remove();
                console.log('✅ Đã xóa khách sạn');
            }
        }

        if (target.classList.contains('remove-schedule') || target.closest('.remove-schedule')) {
            const item = target.closest('.schedule-item');
            if (item) {
                item.remove();
                console.log('✅ Đã xóa lịch trình');
            }
        }

        if (target.classList.contains('remove-people') || target.closest('.remove-people')) {
            const item = target.closest('.people-item');
            if (item) {
                item.remove();
                console.log('✅ Đã xóa khách hàng');
            }
        }
    });

    // console.log('✅ Script initialized');
    // console.log(`📊 Số lượng hiện tại:
    // - Phương tiện: ${transportCount}
    // - Khách sạn: ${accommodationCount}
    // - Lịch trình: ${scheduleCount}
    // - Khách hàng: ${peopleCount}`);
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
?>