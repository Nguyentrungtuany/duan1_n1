<style>
    .report-img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid #eee;
    }
    .table-hover tbody tr:hover {
        background-color: #fff3e0 !important; /* màu cam nhạt đẹp */
    }
</style>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">📊 Danh sách báo cáo</h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-bordered table-hover mb-0 align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th width="60">ID</th>
                        <th width="100">Ảnh</th>
                        <th>Tour</th>
                        <th>Hướng dẫn viên</th>
                        <th width="160">Ngày gửi</th>
                        <th width="150">Hành động</th>
                    </tr>
                </thead>
                <tbody>

                <?php foreach ($reports as $report): ?>

                    <tr>
                        <td class="text-center fw-bold"><?= $report['id'] ?></td>

                        <!-- ẢNH -->
                        <td class="text-center">
                            <?php 
                                $img = $report['images'][0] ?? null;
                                $src = $img ? $img : "https://via.placeholder.com/80";
                            ?>
                            <img src="<?= $src ?>" class="report-img">
                        </td>

                        <td><?= htmlspecialchars($report['tour_name']) ?></td>

                        <td><?= htmlspecialchars($report['guide_name']) ?></td>

                        <td class="text-center">
                            <span class="badge bg-primary p-2">
                                <?= date('d-m-Y H:i', strtotime($report['created_at'])) ?>
                            </span>
                        </td>

                        <td class="text-center">
                            <a href="index.php?act=report-detail&id=<?= $report['id'] ?>" 
                               class="btn btn-sm btn-info">
                                🔍 Chi tiết
                            </a>
                        </td>
                    </tr>

                <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
