<?php
require_once __DIR__ . '/../layout/admin/header.php';

foreach ($DataQltour as &$item) {
    $item['destination']      = !empty($item['destination'])      ? json_decode($item['destination'], true)      : [];
    $item['transports']       = !empty($item['transports'])       ? json_decode($item['transports'], true)       : [];
    $item['accommodations']   = !empty($item['accommodations'])   ? json_decode($item['accommodations'], true)   : [];
    $item['schedules']        = !empty($item['schedules'])        ? json_decode($item['schedules'], true)        : [];
}

?>



<!-- main content start-->
<div id="page-wrapper">
    <div class="main-page">
        <div class="tables">
            <h2 class="title1">Quản lý Tour</h2>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Danh sách Tour</h4>
                    <div class="mb-3">

                    </div>
                </div>
                <div class="panel-body">
                    <a href="index.php?act=addqltour" class="btn btn-success btn-sm">
                        <i class="fa fa-plus"></i> Thêm mới
                    </a>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên Tour</th>
                                    <th>Danh mục</th>
                                    <th>Mô tả</th>
                                    <th>Giá</th>
                                    <th>Lịch trình</th>
                                    <th>Trạng thái</th>
                                    <th>Điểm đến</th>
                                    <!-- <th>Phương tiện</th> -->
                                    <!-- <th>Khách sạn</th> -->
                                    <!-- <th>Lịch trình</th> -->
                                    <!-- <th>Cập nhật</th> -->
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($DataQltour as $data): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($data['id']) ?></td>
                                        <td><?= htmlspecialchars($data['name']) ?></td>
                                        <td><?= htmlspecialchars($data['category_name']) ?></td>
                                        <td style="max-width: 200px;">
                                            <?= htmlspecialchars(substr($data['description'], 0, 100)) ?>...
                                        </td>

                                        <td><strong><?= number_format($data['price'], 0, ',', '.') ?> VNĐ</strong></td>
                                        <td>
                                            <span class="label <?= $data['status'] == 'open' ? 'label-success' : 'label-default' ?>">
                                                <?= htmlspecialchars($data['status']) ?>
                                            </span>
                                        </td>

                                        <!-- Lịch trình -->
                                        <td style="min-width: 300px;">
                                            <?php if (!empty($data['schedules'])): ?>
                                                <?php foreach ($data['schedules'] as $schedule): ?>
                                                    <div class="schedule-item" style="margin-bottom: 10px; padding: 8px; background: #f9f9f9; border-left: 3px solid #5cb85c; border-radius: 3px;">
                                                        <div style="margin-bottom: 5px;">
                                                            <strong style="color: #5cb85c;">Ngày <?= $schedule['day_number'] ?>:</strong>
                                                        </div>
                                                        <div style="margin-bottom: 5px;">
                                                            <strong><i class="fa fa-map-marker"></i> <?= htmlspecialchars($schedule['location']) ?></strong>
                                                        </div>
                                                        <div style="font-size: 12px; color: #666; margin-bottom: 5px;">
                                                            <?= htmlspecialchars(substr($schedule['activities'], 0, 100)) ?>
                                                        </div>
                                                        <?php if (!empty($schedule['notes'])): ?>
                                                            <div style="font-size: 11px; color: #d9534f; font-style: italic;">
                                                                <i class="fa fa-info-circle"></i> <?= htmlspecialchars($schedule['notes']) ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <span class="text-muted">Chưa có lịch trình</span>
                                            <?php endif; ?>
                                        </td>
                                        <!-- Điểm đến -->
                                        <td>
                                            <?php if (!empty($data['destination'])): ?>
                                                <strong><?= htmlspecialchars($data['destination']['name']) ?></strong><br>
                                                <small class="text-muted"><?= htmlspecialchars($data['destination']['location']) ?></small>
                                            <?php else: ?>
                                                <span class="text-muted">Chưa có</span>
                                            <?php endif; ?>
                                        </td>


                                        <td style="min-width: 120px;">
                                            <a href="index.php?act=editqltour&id=<?= $data['id'] ?>"
                                                class="btn btn-primary btn-sm" style="margin-bottom: 5px;">
                                                <i class="fa fa-edit"></i> Sửa
                                            </a>
                                            <a href="index.php?act=deleteqltour&id=<?= $data['id'] ?>"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Bạn có chắc muốn xóa tour này?')">
                                                <i class="fa fa-trash"></i> Xóa
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
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

    #page-wrapper {
        overflow: auto !important;
        height: auto !important;
        min-height: 100vh;
    }

    .main-page {
        overflow: visible !important;
    }

    .table td {
        vertical-align: top !important;
    }

    .transport-item,
    .accommodation-item {
        border-left: 3px solid #337ab7;
    }

    .schedule-item:last-child {
        margin-bottom: 0 !important;
    }

    </><?php
        require_once __DIR__ . '/../layout/admin/footer.php';
        ?>