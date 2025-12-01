<?php
require_once __DIR__ . '/../../layout//admin/header.php';
?>

<!-- main content start-->
<div id="page-wrapper">
    <div class="main-page">
        <div class="forms">
            <h2 class="title1">Sửa điểm đến</h2>
            
            <div class="form-grids row widget-shadow" data-example-id="basic-forms">
                <div class="form-title">
                    <h4>Form cập nhật thông tin điểm đến:</h4>
                </div>
                
                <div class="form-body">
                    <form method="POST" action="index.php?act=destination-update">
                        <!-- Hidden ID -->
                        <input type="hidden" name="id" value="<?= isset($destination['id']) ? $destination['id'] : '' ?>">

                        <!-- Tên điểm đến -->
                        <div class="form-group">
                            <label for="name">Tên điểm đến <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="<?= isset($destination['name']) ? htmlspecialchars($destination['name']) : '' ?>"
                                placeholder="Nhập tên điểm đến" required>
                        </div>

                        <!-- Mô tả -->
                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="4"
                                placeholder="Nhập mô tả điểm đến"><?= isset($destination['description']) ? htmlspecialchars($destination['description']) : '' ?></textarea>
                        </div>

                        <!-- Địa điểm -->
                        <div class="form-group">
                            <label for="location">Địa điểm <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="location" name="location"
                                value="<?= isset($destination['location']) ? htmlspecialchars($destination['location']) : '' ?>"
                                placeholder="Nhập địa điểm" required>
                        </div>

                        <!-- Buttons -->
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary" name="update">
                                <i class="fa fa-save"></i> Cập nhật
                            </button>
                            <a href="index.php?act=destination-index" class="btn btn-default">
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
require_once __DIR__ . '/../../layout//admin/footer.php';
?>