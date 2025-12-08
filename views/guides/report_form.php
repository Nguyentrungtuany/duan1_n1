<?php
require_once 'views/layout/guides/header.php';
?>

<style>
    .report-container {
        max-width: 900px;
        margin: 30px auto;
        padding: 20px;
    }

    .card {
        border: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        background: white;
    }

    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        border-radius: 8px 8px 0 0;
    }

    .card-body {
        padding: 30px;
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }

    .form-control {
        border-radius: 5px;
        border: 1px solid #ddd;
        padding: 10px 15px;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 12px 30px;
        font-weight: 600;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .tour-info {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .tour-info h5 {
        margin: 0 0 10px 0;
        color: #667eea;
    }

    .tour-info p {
        margin: 5px 0;
        color: #666;
    }

    .form-group {
        margin-bottom: 20px;
    }
</style>

<div id="page-wrapper">
    <div class="main-page">
        <div class="report-container">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <i class="fa fa-check-circle"></i> <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <i class="fa fa-exclamation-triangle"></i> <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <?php if ($reported): ?>
                <div class="card">
                    <div class="card-header">
                        <h3 style="margin: 0;"><i class="fa fa-check-circle"></i> Đã gửi báo cáo</h3>
                    </div>
                    <div class="card-body text-center">
                        <i class="fa fa-check-circle fa-5x text-success" style="margin-bottom: 20px;"></i>
                        <h4>Bạn đã gửi báo cáo cho tour này rồi!</h4>
                        <p class="text-muted">Không thể gửi báo cáo trùng lặp cho cùng một tour.</p>
                        <a href="?act=job-guide" class="btn btn-primary" style="margin-top: 20px;">
                            <i class="fa fa-arrow-left"></i> Quay lại danh sách công việc
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="card">
                    <div class="card-header">
                        <h3 style="margin: 0;"><i class="fa fa-file-text-o"></i> BÁO CÁO SAU TOUR</h3>
                    </div>
                    <div class="card-body">
                        <div class="tour-info">
                            <h5><i class="fa fa-suitcase"></i> <?= htmlspecialchars($booking['tour_name']) ?></h5>
                            <p>
                                <strong><i class="fa fa-calendar"></i> Ngày khởi hành:</strong> 
                                <?= date('d/m/Y', strtotime($booking['start_date'])) ?>
                                <span style="margin: 0 10px;">→</span>
                                <strong>Ngày kết thúc:</strong> 
                                <?= date('d/m/Y', strtotime($booking['end_date'])) ?>
                            </p>
                            <p>
                                <strong><i class="fa fa-hashtag"></i> Mã booking:</strong> #<?= $booking['booking_id'] ?>
                            </p>
                        </div>

                        <form action="?act=gui-bao-cao-tour" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="booking_id" value="<?= $booking['booking_id'] ?>">

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fa fa-list-alt"></i> Tóm tắt tour <span class="text-danger">*</span>
                                </label>
                                <textarea 
                                    name="tour_summary" 
                                    class="form-control" 
                                    rows="4" 
                                    required
                                    placeholder="Mô tả tổng quan về chuyến tour..."></textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fa fa-users"></i> Tình hình khách hàng <span class="text-danger">*</span>
                                </label>
                                <textarea 
                                    name="customer_situation" 
                                    class="form-control" 
                                    rows="4" 
                                    required
                                    placeholder="Đánh giá về khách hàng..."></textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fa fa-exclamation-triangle"></i> Các sự cố (nếu có)
                                </label>
                                <textarea 
                                    name="incidents" 
                                    class="form-control" 
                                    rows="3"
                                    placeholder="Mô tả các sự cố..."></textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fa fa-lightbulb-o"></i> Đề xuất & cải thiện
                                </label>
                                <textarea 
                                    name="suggestions" 
                                    class="form-control" 
                                    rows="4"
                                    placeholder="Đề xuất cải thiện..."></textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fa fa-camera"></i> Ảnh đính kèm (tối đa 10 ảnh)
                                </label>
                                <input 
                                    type="file" 
                                    name="images[]" 
                                    multiple 
                                    accept="image/*" 
                                    class="form-control">
                                <small class="text-muted">Chỉ chấp nhận ảnh JPG, PNG, GIF</small>
                            </div>

                            <hr style="margin: 30px 0;">

                            <div class="text-right">
                                <a href="?act=job-guide" class="btn btn-default" style="margin-right: 10px;">
                                    <i class="fa fa-times"></i> Hủy bỏ
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-paper-plane"></i> Gửi Báo Cáo
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
require_once 'views/layout/guides/footer.php';
?>