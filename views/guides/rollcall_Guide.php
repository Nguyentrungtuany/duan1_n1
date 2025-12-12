<?php
// views/guides/rollcall_Guide.php
// Các biến từ controller: $booking, $people, $validDates, $selected_date, $selected_session, $att_map, $today

foreach (['tour', 'guide'] as $field) {
    if (isset($booking[$field]) && is_string($booking[$field])) {
        $booking[$field] = json_decode($booking[$field], true);
    }
}

$vnDays = [
    'Monday' => 'Thứ Hai', 'Tuesday' => 'Thứ Ba', 'Wednesday' => 'Thứ Tư',
    'Thursday' => 'Thứ Năm', 'Friday' => 'Thứ Sáu',
    'Saturday' => 'Thứ Bảy', 'Sunday' => 'Chủ Nhật'
];

$sessionLabels = [
    'morning' => 'Buổi Sáng',
    'afternoon' => 'Buổi Chiều',
    'evening' => 'Buổi Tối'
];

$currentSessionLabel = $sessionLabels[$selected_session] ?? 'Buổi Sáng';

// Xác định có được chỉnh sửa không: CHỈ hôm nay mới được lưu
$can_edit = ($selected_date === $today);
$is_past = ($selected_date < $today);
$is_future = ($selected_date > $today);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Điểm Danh - <?= htmlspecialchars($booking['tour']['name'] ?? '') ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .attendance-page { padding: 20px; }
        .attendance-container { max-width: 1400px; margin: 0 auto; }
        .back-btn { display: inline-flex; align-items: center; gap: 8px; background: white; color: #333; padding: 12px 24px; border-radius: 10px; text-decoration: none; font-weight: 600; box-shadow: 0 4px 12px rgba(0,0,0,0.1); transition: all 0.3s; margin-bottom: 20px; }
        .back-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); color: #667eea; }
        .main-card { background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
        .header-section { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px; color: white; }
        .header-section h2 { font-size: 32px; font-weight: 700; margin-bottom: 20px; }
        .tour-info-box { background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); padding: 25px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.2); }
        .tour-info-box h3 { font-size: 24px; margin-bottom: 15px; }
        .tour-stats { display: flex; flex-wrap: wrap; gap: 15px; }
        .stat-item { background: rgba(255,255,255,0.1); padding: 12px 16px; border-radius: 10px; min-width: 200px; }
        .content-section { padding: 40px; }
        .control-section { background: #f9fafb; padding: 30px; border-radius: 15px; border: 2px solid #e5e7eb; margin-bottom: 30px; }
        .section-title { font-size: 20px; font-weight: 600; color: #1f2937; margin-bottom: 20px; }
        .form-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 20px; }
        .form-group label { font-weight: 600; color: #4b5563; margin-bottom: 8px; }
        .form-group select { padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; width: 100%; background: white; }
        .form-group select:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.1); }
        .quick-actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 20px; }
        .btn-action { padding: 12px 24px; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .btn-action:disabled { opacity: 0.6; cursor: not-allowed; }
        .btn-success { background: #10b981; color: white; }
        .btn-danger { background: #ef4444; color: white; }
        .stats-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin: 30px 0; }
        .stat-card { padding: 20px; border-radius: 12px; text-align: center; color: white; box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
        .stat-card.main { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .stat-card.success { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .stat-card.danger { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
        .stat-card .number { font-size: 32px; font-weight: 700; margin-bottom: 5px; }
        .stat-card .label { font-size: 13px; opacity: 0.9; }
        .table-container { background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); margin-bottom: 30px; }
        .attendance-table { width: 100%; border-collapse: collapse; }
        .attendance-table thead { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .attendance-table th { color: white; padding: 18px 15px; text-align: center; font-weight: 600; }
        .attendance-table tbody tr { border-bottom: 1px solid #f3f4f6; transition: background 0.2s; }
        .attendance-table tbody tr:hover { background: #f9fafb; }
        .attendance-table td { padding: 18px 15px; text-align: center; color: #4b5563; }
        .person-name { text-align: left; font-weight: 600; color: #1f2937; font-size: 15px; }
        .toggle-switch { display: flex; align-items: center; justify-content: center; gap: 12px; }
        .switch { position: relative; width: 50px; height: 26px; }
        .switch input { opacity: 0; width: 0; height: 0; }
        .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background: #ccc; border-radius: 26px; transition: 0.4s; }
        .slider:before { position: absolute; content: ""; height: 20px; width: 20px; left: 3px; bottom: 3px; background: white; border-radius: 50%; transition: 0.4s; }
        input:checked + .slider { background: #10b981; }
        input:checked + .slider:before { transform: translateX(24px); }
        .status-badge { padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 600; }
        .badge-present { background: #d1fae5; color: #065f46; }
        .badge-absent { background: #fee2e2; color: #991b1b; }
        .note-input { width: 100%; padding: 8px 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px; }
        .note-input[readonly] { background: #f3f4f6; }
        .notes-section { background: #f9fafb; padding: 25px; border-radius: 15px; margin-bottom: 30px; }
        .notes-section textarea { width: 100%; padding: 15px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 15px; min-height: 120px; resize: vertical; }
        .notes-section textarea[readonly] { background: #f3f4f6; }
        .submit-area { text-align: center; padding: 30px 0; }
        .btn-submit { padding: 16px 48px; font-size: 16px; font-weight: 700; border: none; border-radius: 12px; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .btn-submit.primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .btn-submit.primary:hover { transform: translateY(-3px); }
        .btn-submit.cancel { background: white; color: #4b5563; border: 2px solid #e5e7eb; margin-left: 15px; }
        .alert-box { padding: 20px; border-radius: 12px; text-align: center; font-weight: 600; margin: 20px 0; }
        .alert-history { background: #dbeafe; color: #1e40af; border: 1px solid #93c5fd; }
        .alert-future { background: #fef3c7; color: #92400e; border: 1px solid #fcd34d; }
        .alert-today { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        @media (max-width: 768px) { .form-row { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<div class="attendance-page">
    <div class="attendance-container">
        <a href="index.php?act=job-guide" class="back-btn">← Quay lại danh sách công việc</a>

        <div class="main-card">
            <div class="header-section">
                <h2>Điểm Danh Tour</h2>
                <div class="tour-info-box">
                    <h3><?= htmlspecialchars($booking['tour']['name'] ?? 'Không xác định') ?></h3>
                    <div class="tour-stats">
                        <div class="stat-item">
                            <span><?= date('d/m/Y', strtotime($booking['start_date'])) ?> → <?= date('d/m/Y', strtotime($booking['end_date'])) ?></span>
                        </div>
                        <div class="stat-item"><span><?= count($people) ?> người tham gia</span></div>
                        <div class="stat-item"><span>Booking ID: <?= $booking['id'] ?></span></div>
                    </div>
                </div>
            </div>

            <div class="content-section">
                <form action="index.php?act=save-diem-danh" method="POST" id="attendanceForm">
                    <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                    <input type="hidden" name="attendance_date" value="<?= $selected_date ?>">
                    <input type="hidden" name="session" value="<?= $selected_session ?>">

                    <div class="control-section">
                        <h4 class="section-title">
                            Điểm danh — <?= date('d/m/Y', strtotime($selected_date)) ?> 
                            <span style="color:#667eea;">— <?= $currentSessionLabel ?></span>
                        </h4>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Chọn ngày</label>
                                <select id="date-select" onchange="updateUrl()">
                                    <?php 
                                    $dayCounter = 1;
                                    foreach ($validDates as $dateRow): 
                                        $d = $dateRow['date'];
                                        $obj = new DateTime($d);
                                        $label = "Ngày $dayCounter │ " . $obj->format('d/m/Y') . " (" . $vnDays[$obj->format('l')] . ")";
                                        if ($d === $today) $label .= " → HÔM NAY";
                                        $selected = ($d === $selected_date) ? 'selected' : '';
                                    ?>
                                        <option value="<?= $d ?>" <?= $selected ?>><?= $label ?></option>
                                    <?php $dayCounter++; endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Chọn buổi</label>
                                <select id="session-select" onchange="updateUrl()">
                                    <option value="morning" <?= $selected_session === 'morning' ? 'selected' : '' ?>>Buổi Sáng</option>
                                    <option value="afternoon" <?= $selected_session === 'afternoon' ? 'selected' : '' ?>>Buổi Chiều</option>
                                    <option value="evening" <?= $selected_session === 'evening' ? 'selected' : '' ?>>Buổi Tối</option>
                                </select>
                            </div>
                        </div>

                        <!-- Thông báo trạng thái ngày -->
                        <?php if ($is_past): ?>
                            <div class="alert-box alert-history">
                                Bạn đang xem <strong>lịch sử điểm danh</strong> ngày <?= date('d/m/Y', strtotime($selected_date)) ?> — Không thể chỉnh sửa
                            </div>
                        <?php elseif ($is_future): ?>
                            <div class="alert-box alert-future">
                                Ngày <?= date('d/m/Y', strtotime($selected_date)) ?> chưa đến — Bạn chỉ có thể xem trước (chưa điểm danh)
                            </div>
                        <?php else: ?>
                            <div class="alert-box alert-today">
                                Hôm nay (<?= date('d/m/Y') ?>) — Bạn có thể điểm danh buổi <?= $currentSessionLabel ?>
                            </div>
                        <?php endif; ?>

                        <div class="quick-actions">
                            <button type="button" class="btn-action btn-success" onclick="checkAll()" <?= $can_edit ? '' : 'disabled' ?>>
                                Có mặt tất cả
                            </button>
                            <button type="button" class="btn-action btn-danger" onclick="uncheckAll()" <?= $can_edit ? '' : 'disabled' ?>>
                                Vắng tất cả
                            </button>
                        </div>
                    </div>

                    <!-- Phần thống kê và bảng điểm danh giữ nguyên như cũ -->
                    <div class="stats-row">
                        <div class="stat-card main"><div class="number" id="total-people"><?= count($people) ?></div><div class="label">Tổng số người</div></div>
                        <div class="stat-card success"><div class="number" id="present-count">0</div><div class="label">Có mặt</div></div>
                        <div class="stat-card danger"><div class="number" id="absent-count">0</div><div class="label">Vắng mặt</div></div>
                    </div>

                    <div class="table-container">
                        <table class="attendance-table">
                            <thead>
                                <tr><th>STT</th><th>Họ và tên</th><th>Số điện thoại</th><th>Ngày sinh</th><th>Trạng thái</th><th>Ghi chú</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach ($people as $index => $person): 
                                    $pid = $person['id'];
                                    $data = $att_map[$pid] ?? null;
                                    $status = $data['status'] ?? 'not_checked';
                                    if ($can_edit && $status === 'not_checked') $status = 'present';
                                    $is_present = ($status === 'present');
                                    $note = $data['note'] ?? '';
                                ?>
                                <tr>
                                    <td style="font-weight:600;"><?= $index + 1 ?></td>
                                    <td class="person-name"><?= htmlspecialchars($person['fullname']) ?></td>
                                    <td><?= htmlspecialchars($person['phone']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($person['date'])) ?></td>
                                    <td>
                                        <div class="toggle-switch">
                                            <label class="switch">
                                                <input type="checkbox" class="attendance-checkbox" name="attendance[<?= $pid ?>]" value="1"
                                                       <?= $is_present ? 'checked' : '' ?> <?= $can_edit ? '' : 'disabled' ?> onchange="updateStatus(<?= $pid ?>)">
                                                <span class="slider"></span>
                                            </label>
                                            <span id="status-<?= $pid ?>" class="status-badge <?= $is_present ? 'badge-present' : 'badge-absent' ?>">
                                                <?= $is_present ? 'Có mặt' : 'Vắng mặt' ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="note-input" name="notes[<?= $pid ?>]" value="<?= htmlspecialchars($note) ?>"
                                               placeholder="Ghi chú..." <?= $can_edit ? '' : 'readonly' ?>>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="notes-section">
                        <label>Ghi chú chung — <?= date('d/m/Y', strtotime($selected_date)) ?> <?= $currentSessionLabel ?></label>
                        <textarea name="general_notes" placeholder="Ghi chú chung cho buổi này..." <?= $can_edit ? '' : 'readonly' ?>></textarea>
                    </div>

                    <div class="submit-area">
                        <?php if ($can_edit): ?>
                            <button type="submit" class="btn-submit primary">Lưu điểm danh <?= $currentSessionLabel ?></button>
                        <?php endif; ?>
                        <a href="index.php?act=job-guide" class="btn-submit cancel">Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function updateUrl() {
    const date = document.getElementById('date-select').value;
    const session = document.getElementById('session-select').value;
    window.location.href = `index.php?act=rollcall_Guide&id=<?= $booking['id'] ?>&date=${date}&session=${session}`;
}

function updateStatistics() {
    const checkboxes = document.querySelectorAll('.attendance-checkbox');
    let present = 0;
    checkboxes.forEach(cb => { if (cb.checked) present++; });
    document.getElementById('present-count').textContent = present;
    document.getElementById('absent-count').textContent = checkboxes.length - present;
}

function checkAll() {
    document.querySelectorAll('.attendance-checkbox').forEach(cb => cb.checked = true);
    document.querySelectorAll('.status-badge').forEach(b => { b.textContent = 'Có mặt'; b.className = 'status-badge badge-present'; });
    updateStatistics();
}

function uncheckAll() {
    document.querySelectorAll('.attendance-checkbox').forEach(cb => cb.checked = false);
    document.querySelectorAll('.status-badge').forEach(b => { b.textContent = 'Vắng mặt'; b.className = 'status-badge badge-absent'; });
    updateStatistics();
}

function updateStatus(id) {
    const cb = document.querySelector(`input[name="attendance[${id}]"]`);
    const badge = document.getElementById('status-' + id);
    badge.textContent = cb.checked ? 'Có mặt' : 'Vắng mặt';
    badge.className = cb.checked ? 'status-badge badge-present' : 'badge-absent';
    updateStatistics();
}

window.onload = updateStatistics;
</script>
</body>
</html>