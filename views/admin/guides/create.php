<?php
require_once __DIR__ . '/../../layout/admin/header.php';
?>

<!-- main content start-->
<div id="page-wrapper">
    <div class="main-page">
        <h2 class="text-center mb-3">Thêm hướng dẫn viên mới</h2>
    <form action="" method="POST" class="col-md-8 mx-auto">
        <div class="mb-3">
            <label class="form-label">Họ tên</label>
            <input type="text" name="full_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Chuyên môn</label>
            <input type="text" name="specialization" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Kinh nghiệm (năm)</label>
            <input type="number" name="experience_years" class="form-control" min="0">
        </div>
        <div class="mb-3">
            <label class="form-label">Chứng chỉ</label>
            <textarea name="certificates" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Ngôn ngữ</label>
            <input type="text" name="languages" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Trạng thái</label>
            <select name="status" class="form-select">
                <option value="active">Đang hoạt động</option>
                <option value="inactive">Tạm nghỉ</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Chọn tài khoản hướng dẫn viên</label>
            <select name="user_id" class="form-select" required>
                <option value="">-- Chọn user --</option>
                <?php foreach ($availableUsers as $user): ?>
                    <option value="<?= $user['id'] ?>">
                        <?= htmlspecialchars($user['full_name'] . ' (' . $user['username'] . ' - ' . $user['email'] . ')') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button class="btn btn-success w-100">Lưu</button>
        <button type="button" class="btn btn-secondary w-100" onclick="window.location.href='?act=admin_guides'">Hủy</button>
    </form>
    </div>
</div>

<?php
require_once __DIR__ . '/../../layout/admin/footer.php';
?>

