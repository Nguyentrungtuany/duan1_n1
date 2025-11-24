<?php
require_once __DIR__ . '/../../layout/header.php';
// print_r($allTour);
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
                    <form method="POST" action="<?php echo BASE_URL; ?>index.php?act=bookings-create" enctype="multipart/form-data">

                        <!-- Tên -->
                        <div class="form-group">
                            <label for="fullname">Tên</label>
                            <input type="text" class="form-control" id="fullname" name="fullname"
                                placeholder="Nhập tên" required>
                        </div>
                        <!-- ngày sinh -->
                        <div class="form-group">
                            <label for="date">Ngày sinh</label>
                            <input type="date" class="form-control" id="date" name="date"
                                placeholder="Nhập ngày sinh" required>
                        </div>
                        <!-- sdt -->
                        <div class="form-group">
                            <label for="phone">số điện thoại</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                placeholder="Nhập số điện thoại" required>
                        </div>
                        <!-- ngày bắt đầu -->
                        <div class="form-group">
                            <label for="start_date">Ngày bắt đầu</label>
                            <input type="date" class="form-control" id="start_date" name="start_date"
                                placeholder="Nhập số điện thoại" required>
                        </div>
                        <!-- Ngay ket thuc -->
                        <div class="form-group">
                            <label for="end_date">Ngày kết thúc</label>
                            <input type="date" class="form-control" id="end_date" name="end_date"
                                placeholder="Nhập số điện thoại" required>
                        </div>
                        <!-- Tên Tour -->
                        <div class="form-group">
                            <label for="tour_id">Chọn Tour <span class="text-danger">*</span></label>
                            <select class="form-control" id="tour_id" name="tour_id" required>
                                <option value="">-- Chọn tour --</option>

                                <?php if (!empty($allTour)): ?>
                                    <?php foreach ($allTour as $tour): ?>
                                        <option value="<?= $tour['id']; ?>"
                                            <?= (isset($booking['tour_id']) && $booking['tour_id'] == $tour['id']) ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($tour['name']); ?>
                                            — <?= number_format($tour['price']); ?>đ
                                            — <?= htmlspecialchars($tour['category_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </select>
                        </div>




                        <!-- Yêu cầu -->
                        <div class="form-group">
                            <label for="special_request">Yêu cầu </label>
                            <textarea class="form-control" id="special_request" name="special_request" rows="4"
                                placeholder="Nhập Yêu cầu tour"></textarea>
                        </div>

                        <!-- Ngày bắt đầu và Ngày kết thúc -->
                        <!-- <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date">Ngày bắt đầu <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                        value="" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_date">Ngày kết thúc <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                        value="" required>
                                </div>
                            </div>
                        </div> -->




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
<style>
    html,
    body {
        overflow: auto !important;
        height: auto !important;
        max-height: none !important;
    }
</style>
<?php
require_once __DIR__ . '/../../layout/footer.php';
?>