<style>
    body {
        background: #fafafa;
    }

    .title-bar {
        background: linear-gradient(90deg, #ff5722, #ff7043);
        color: white;
        padding: 18px 25px;
        border-radius: 12px;
        font-size: 22px;
        font-weight: bold;
        box-shadow: 0 4px 10px rgba(255, 87, 34, 0.3);
    }

    .report-img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 10px;
        border: 3px solid #ffe0d1;
        transition: 0.2s;
    }
    .report-img:hover {
        transform: scale(1.08);
        border-color: #ff5722;
    }

    .table-hover tbody tr:hover {
        background-color: #fff2e6 !important;
    }

    .badge-date {
        font-size: 14px;
        background: linear-gradient(90deg, #ff8a50, #ff7043);
        padding: 6px 10px;
        border-radius: 6px;
    }

    .btn-detail {
        background: #ff5722;
        border: none;
        color: white;
        border-radius: 6px;
        padding: 6px 14px;
        transition: 0.2s;
    }
    .btn-detail:hover {
        background: #e64a19;
        color: white;
        transform: translateY(-2px);
    }

    .card-custom {
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
</style>

<div class="container mt-4">

    <div class="title-bar mb-4">
        📊 Danh sách báo cáo
    </div>

    <div class="card card-custom">
        <div class="card-body p-0">
            <table class="table table-bordered table-hover mb-0 align-middle">
                <thead style="background:#ff7043; color:white;" class="text-center">
                    <tr>
                        <th width="60">ID</th>
                        <th width="100">Ảnh</th>
                        <th>Tour</th>
                        <th>Hướng dẫn viên</th>
                        <th width="180">Ngày gửi</th>
                        <th width="150">Hành động</th>
                    </tr>
                </thead>

                <tbody>

                <?php foreach ($reports as $report): ?>
                    <tr>
                        <td class="text-center fw-bold"><?= $report['id'] ?></td>

                        <!-- Ảnh đại diện -->
                        <td class="text-center">
                            <?php 
                                $img = $report['images'][0] ?? null;
                                $src = $img ?: "https://via.placeholder.com/80";
                            ?>
                            <img src="<?= $src ?>" class="report-img">
                        </td>

                        <td class="fw-semibold"><?= htmlspecialchars($report['tour_name']) ?></td>
                        <td><?= htmlspecialchars($report['guide_name']) ?></td>

                        <td class="text-center">
                            <span class="badge-date">
                                <?= date('d-m-Y H:i', strtotime($report['created_at'])) ?>
                            </span>
                        </td>

                        <td class="text-center">
                            <a href="index.php?act=report-detail&id=<?= $report['id'] ?>" 
                                class="btn btn-detail btn-sm">
                                🔍 Xem chi tiết
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>

</div>
