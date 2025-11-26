<?php
require_once __DIR__ . '/../layout/admin/header.php';

// Decode JSON data nếu cần
if (isset($DataQltour['destination']) && is_string($DataQltour['destination'])) {
    $DataQltour['destination'] = json_decode($DataQltour['destination'], true);
}
// if (isset($DataQltour['transports']) && is_string($DataQltour['transports'])) {
//     $DataQltour['transports'] = json_decode($DataQltour['transports'], true);
// }
// if (isset($DataQltour['accommodations']) && is_string($DataQltour['accommodations'])) {
//     $DataQltour['accommodations'] = json_decode($DataQltour['accommodations'], true);
// }
// if (isset($DataQltour['schedules']) && is_string($DataQltour['schedules'])) {
//     $DataQltour['schedules'] = json_decode($DataQltour['schedules'], true);
// }
?>


<!-- main content start-->
<div id="page-wrapper">
    <div class="main-page">
        <div class="forms">
            <h2 class="title1">Cập nhật Tour</h2>
            <div class="form-grids row widget-shadow" data-example-id="basic-forms">
                <div class="form-title">
                    <h4>Form cập nhật thông tin Tour:</h4>
                </div>
                <div class="form-body">
                    <form method="POST" action="<?php echo BASE_URL; ?>index.php?act=updateqltour" enctype="multipart/form-data">
                        <!-- Hidden ID -->
                        <input type="hidden" name="id" value="<?php echo isset($DataQltour['id']) ? $DataQltour['id'] : ''; ?>">

                        <h4 class="text-primary" style="margin-top: 20px; margin-bottom: 15px; border-bottom: 2px solid #337ab7; padding-bottom: 10px;">
                            <i class="fa fa-info-circle"></i> Thông tin cơ bản
                        </h4>

                        <!-- Tên Tour -->
                        <div class="form-group">
                            <label for="name">Tên Tour <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="<?php echo isset($DataQltour['name']) ? htmlspecialchars($DataQltour['name']) : ''; ?>"
                                placeholder="Nhập tên tour" required>
                        </div>

                        <!-- Danh mục -->
                        <div class="form-group">
                            <label for="category_id">Danh mục <span class="text-danger">*</span></label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="">-- Chọn danh mục --</option>

                                <?php foreach ($allCategory as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>"
                                        <?php echo (isset($DataQltour['category_id']) && $DataQltour['category_id'] == $cat['id']) ? 'selected' : ''; ?>>
                                        <?php echo $cat['name']; ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </div>


                        <!-- Điểm đến -->
                        <div class="form-group">
                            <label for="destination_id">Điểm đến <span class="text-danger">*</span></label>
                            <select class="form-control" id="destination_id" name="destination_id" required>
                                <option value="">-- Chọn điểm đến --</option>
                                <option value="1" <?php echo (isset($DataQltour['destination_id']) && $DataQltour['destination_id'] == '1') ? 'selected' : ''; ?>>Hạ Long</option>
                                <option value="2" <?php echo (isset($DataQltour['destination_id']) && $DataQltour['destination_id'] == '2') ? 'selected' : ''; ?>>Singapore</option>
                            </select>
                        </div>

                        <!-- Mô tả -->
                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="4"
                                placeholder="Nhập mô tả tour"><?php echo isset($DataQltour['description']) ? htmlspecialchars($DataQltour['description']) : ''; ?></textarea>
                        </div>



                        <!-- Giá -->
                        <div class="form-group">
                            <label for="price">Giá (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="price" name="price"
                                value="<?php echo isset($DataQltour['price']) ? $DataQltour['price'] : ''; ?>"
                                placeholder="Nhập giá tour" min="0" required>
                        </div>

                        <!-- Trạng thái -->
                        <div class="form-group">
                            <label for="status">Trạng thái</label>
                            <select class="form-control" id="status" name="status">
                                <option value="open" <?php echo (isset($DataQltour['status']) && $DataQltour['status'] == 'open') ? 'selected' : ''; ?>>Mở đăng ký</option>
                                <option value="inactive" <?php echo (isset($DataQltour['status']) && $DataQltour['status'] == 'inactive') ? 'selected' : ''; ?>>Không hoạt động</option>
                                <option value="full" <?php echo (isset($DataQltour['status']) && $DataQltour['status'] == 'full') ? 'selected' : ''; ?>>Đã đầy</option>
                            </select>
                        </div>


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
require_once __DIR__ . '/../layout/admin/footer.php';
?>