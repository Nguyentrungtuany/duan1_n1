<?php
require_once __DIR__ . '/../layout/header.php';
// print_r($DataQltour);
// print_r($allCategory);
// exit(1);
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
                    <form method="POST" action="<?php echo BASE_URL; ?>index.php?act=createTour" enctype="multipart/form-data">

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
                                <?php if (isset($allCategory) && is_array($allCategory)): ?>
                                    <?php foreach ($allCategory as $category): ?>
                                        <option value="<?php echo $category['id']; ?>"
                                            <?php echo (isset($DataQltour['category_id']) && $DataQltour['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($category['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <!-- Điểm đến -->
                        <div class="form-group">
                            <label for="destination_id">Điểm đến <span class="text-danger">*</span></label>
                            <select class="form-control" id="destination_id" name="destination_id" required>
                                <option value="">-- Chọn điểm đến --</option>
                                <?php if (isset($allDestination) && is_array($allDestination)): ?>
                                    <?php foreach ($allDestination as $destination): ?>
                                        <option value="<?php echo $destination['id']; ?>"
                                            <?php echo (isset($DataQltour['destination_id']) && $DataQltour['destination_id'] == $destination['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($destination['name']); ?>
                                        </option>
                                    <?php endforeach; ?>

                                <?php endif; ?>
                            </select>
                        </div>

                        <!-- Mô tả -->
                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="4"
                                placeholder="Nhập mô tả tour"><?php echo isset($DataQltour['description']) ? htmlspecialchars($DataQltour['description']) : ''; ?></textarea>
                        </div>

                        <!-- Ngày bắt đầu và Ngày kết thúc -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date">Ngày bắt đầu <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                        value="<?php echo isset($DataQltour['start_date']) ? $DataQltour['start_date'] : ''; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_date">Ngày kết thúc <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                        value="<?php echo isset($DataQltour['end_date']) ? $DataQltour['end_date'] : ''; ?>" required>
                                </div>
                            </div>
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
                                <option value="active" <?php echo (isset($DataQltour['status']) && $DataQltour['status'] == 'active') ? 'selected' : ''; ?>>Hoạt động</option>
                                <option value="inactive" <?php echo (isset($DataQltour['status']) && $DataQltour['status'] == 'inactive') ? 'selected' : ''; ?>>Không hoạt động</option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary" name="submit">
                                <i class="fa fa-save"></i> Cập nhật
                            </button>
                            <a href="index.php?act=QlTuor" class="btn btn-default">
                                <i class="fa fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../layout/footer.php';
?>