<style>
    .image-box {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 12px;
        border: 2px solid #eaeaea;
        margin: 6px;
        transition: transform .2s;
    }

    .image-box:hover {
        transform: scale(1.05);
        border-color: #ff6b35;
    }

    .label-title {
        font-weight: 700;
        color: #ff4d2d;
    }

    .content-box {
        background: #fafafa;
        padding: 12px 18px;
        border-radius: 10px;
        border-left: 4px solid #ff6b35;
    }
</style>

<div class="container mt-4">

    <a href="index.php?act=admin-reports" class="btn btn-outline-secondary mb-3">
        ⬅ Quay lại danh sách
    </a>

    <div class="card shadow-lg border-0">
        <div class="card-header text-white py-3" style="background: #ff4d2d;">
            <h4 class="m-0">
                📄 Chi tiết báo cáo #<?= $report['id'] ?? '' ?>
            </h4>
        </div>

        <div class="card-body p-4">

            <!-- Tour -->
            <div class="mb-4">
                <h5 class="label-title">🧭 Thông tin Tour</h5>
                <div class="content-box">
                    <?= htmlspecialchars($report['tour_name'] ?? 'Không có dữ liệu') ?>
                </div>
            </div>

            <!-- Hướng dẫn viên -->
            <div class="mb-4">
                <h5 class="label-title">🧑‍💼 Hướng dẫn viên</h5>
                <div class="content-box">
                    <?= htmlspecialchars($report['guide_name'] ?? 'Không có dữ liệu') ?>
                </div>
            </div>

            <!-- Ngày gửi -->
            <div class="mb-4">
                <h5 class="label-title">📅 Ngày gửi báo cáo</h5>
                <div class="content-box">
                    <span class="fw-bold">
                        <?= isset($report['created_at']) ? date('d-m-Y H:i', strtotime($report['created_at'])) : 'N/A' ?>
                    </span>
                </div>
            </div>

            <!-- Mô tả -->
            <div class="mb-4">
                <h5 class="label-title">📝 Mô tả báo cáo</h5>
                <div class="content-box" style="white-space: pre-line;">
                    <?= htmlspecialchars($report['description'] ?? 'Không có mô tả') ?>
                </div>
            </div>

            <!-- Ảnh đính kèm -->
            <div>
                <h5 class="label-title">🖼 Hình ảnh đính kèm</h5>

                <?php
                $images = $report['images'] ?? [];
                ?>

                <?php if (!empty($images)): ?>
                    <div class="d-flex flex-wrap mt-2">
                        <?php foreach ($images as $img): ?>
                            <img src="<?= htmlspecialchars($img) ?>" class="image-box shadow-sm">
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="content-box text-muted">Không có hình ảnh.</div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>