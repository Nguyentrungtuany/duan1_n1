<?php
require_once __DIR__ . '/../../layout//admin/header.php';
?>

<!-- main content start-->
<div id="page-wrapper">
    <div class="main-page">
        <div class="forms">
            <h2 class="title1">Thêm Điểm đến</h2>

            <div class="form-grids row widget-shadow" data-example-id="basic-forms">
                <div class="form-title">
                    <h4>Form thêm điểm đến mới:</h4>
                </div>

                <div class="form-body">
                    <form method="POST" action="index.php?act=destination-insert">

                        <!-- Tên điểm đến -->
                        <div class="form-group">
                            <label for="name">Tên điểm đến <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Nhập tên điểm đến" required>
                        </div>

                        <!-- Mô tả -->
                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="4"
                                placeholder="Nhập mô tả điểm đến"></textarea>
                        </div>

                        <!-- Địa điểm -->
                        <div class="form-group">
                            <label for="location">Địa điểm <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="location" name="location"
                                placeholder="Nhập địa điểm (vd: Hà Nội, Việt Nam)" required>
                        </div>

                        <!-- Buttons -->
                        <div class="form-group mt-4">
                            <button type="submit" name="add" class="btn btn-success">
                                <i class="fa fa-plus"></i> Thêm
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