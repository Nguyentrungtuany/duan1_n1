<?php
// Decode JSON data
if (isset($booking['tour']) && is_string($booking['tour'])) {
    $booking['tour'] = json_decode($booking['tour'], true);
}
if (isset($booking['customer']) && is_string($booking['customer'])) {
    $booking['customer'] = json_decode($booking['customer'], true);
}

// ==================== LẤY DỮ LIỆU ĐIỂM DANH ====================
$today = date('Y-m-d');
$selected_date = $_GET['date'] ?? $today;

$pdo = connectDB();

// Lấy danh sách ngày hợp lệ
$sql_dates = "SELECT date FROM attendance_dates WHERE booking_id = ? ORDER BY date";
$stmt_dates = $pdo->prepare($sql_dates);
$stmt_dates->execute([$booking_id]);
$validDates = $stmt_dates->fetchAll(PDO::FETCH_COLUMN);

if (empty($validDates)) {
    $start = new DateTime($booking['start_date']);
    $end   = new DateTime($booking['end_date']);
    $end->modify('+1 day');
    $period = new DatePeriod($start, new DateInterval('P1D'), $end);
    foreach ($period as $d) $validDates[] = $d->format('Y-m-d');
}

if (!in_array($selected_date, $validDates)) {
    $selected_date = $today;
}

// Lấy điểm danh ngày đã chọn
$sql_att = "SELECT 
                bp.id,
                bp.fullname,
                bp.phone,
                bp.date AS birthdate,
                a.status,
                a.note
            FROM bookings_people bp
 LEFT JOIN attendances a 
      ON a.booking_people_id = bp.id 
     AND a.attendance_date = ?
 WHERE bp.booking_id = ?
 ORDER BY bp.fullname";

$stmt_att = $pdo->prepare($sql_att);
$stmt_att->execute([$selected_date, $booking_id]);
$attendance_data = $stmt_att->fetchAll(PDO::FETCH_ASSOC);

$att_map = [];
foreach ($attendance_data as $row) {
    $att_map[$row['id']] = $row;
}

$is_today = ($selected_date === $today);
$can_edit = $is_today;
?>

<style>
    /* Giữ nguyên 100% CSS đẹp như cũ của bạn */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    .attendance-page { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
    .attendance-container { max-width: 1400px; margin: 0 auto; }
    .back-btn { background: white; color: #333; border: none; padding: 12px 24px; border-radius: 10px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 20px; text-decoration: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: all 0.3s ease; }
    .back-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 12px rgba(0,0,0,0.15); color: #667eea; }
    .main-card { background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
    .header-section { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px; color: white; }
    .header-section h2 { margin: 0 0 20px 0; font-size: 32px; font-weight: 700; display: flex; align-items: center; gap: 12px; }
    .tour-info-box { background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border-radius: 15px; padding: 25px; border: 1px solid rgba(255,255,255,0.2); }
    .tour-info-box h3 { margin: 0 0 15px 0; font-size: 24px; font-weight: 600; }
    .tour-stats { display: flex; flex-wrap: wrap; gap: 15px; }
    .stat-item { display: flex; align-items: center; gap: 10px; background: rgba(255,255,255,0.1); padding: 12px 16px; border-radius: 10px; flex: 1; min-width: 200px; }
    .content-section { padding: 40px; }
    .control-section { background: #f9fafb; border-radius: 15px; padding: 30px; margin-bottom: 30px; border: 2px solid #e5e7eb; }
    .section-title { margin: 0 0 20px 0; color: #1f2937; font-size: 18px; font-weight: 600; display: flex; align-items: center; gap: 8px; }
    .form-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 25px; }
    .form-group { display: flex; flex-direction: column; gap: 8px; }
    .form-group label { font-weight: 600; color: #4b5563; font-size: 14px; display: flex; align-items: center; gap: 6px; }
    .form-group select { padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; transition: all 0.3s ease; }
    .form-group select:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.1); }
    .quick-actions { display: flex; flex-wrap: wrap; gap: 12px; }
    .btn-action { padding: 12px 24px; border: none; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .btn-action:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
    .btn-success { background: #10b981; color: white; }
    .btn-danger { background: #ef4444; color: white; }
    .stats-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-bottom: 25px; }
    .stat-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 12px; text-align: center; box-shadow: 0 4px 12px rgba(102,126,234,0.3); }
    .stat-card.success { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
    .stat-card.danger { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
    .stat-card .number { font-size: 32px; font-weight: 700; margin-bottom: 5px; }
    .stat-card .label { font-size: 13px; opacity: 0.9; }
    .table-container { background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05); margin-bottom: 30px; }
    .attendance-table { width: 100%; border-collapse: collapse; }
    .attendance-table thead { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .attendance-table thead th { color: white; font-weight: 600; padding: 18px 15px; text-align: center; font-size: 14px; }
    .attendance-table tbody tr { transition: all 0.2s ease; border-bottom: 1px solid #f3f4f6; }
    .attendance-table tbody tr:hover { background: #f9fafb; }
    .attendance-table tbody td { padding: 18px 15px; vertical-align: middle; color: #4b5563; text-align: center; }
    .person-name { font-weight: 600; color: #1f2937; font-size: 15px; text-align: left; }
    .toggle-switch { display: flex; align-items: center; justify-content: center; gap: 12px; }
    .switch { position: relative; width: 50px; height: 26px; }
    .switch input { opacity: 0; width: 0; height: 0; }
    .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: 0.4s; border-radius: 26px; }
    .slider:before { position: absolute; content: ""; height: 20px; width: 20px; left: 3px; bottom: 3px; background-color: white; transition: 0.4s; border-radius: 50%; }
    .switch input:checked + .slider { background-color: #10b981; }
    .switch input:checked + .slider:before { transform: translateX(24px); }
    .status-badge { padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 600; display: inline-block; }
    .badge-present { background: #d1fae5; color: #065f46; }
    .badge-absent { background: #fee2e2; color: #991b1b; }
    .note-input { border: 2px solid #e5e7eb; border-radius: 8px; padding: 8px 12px; font-size: 14px; width: 100%; transition: all 0.3s ease; }
    .note-input:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.1); }
    .notes-section { background: #f9fafb; border-radius: 15px; padding: 25px; margin-bottom: 30px; }
    .notes-section label { font-weight: 600; color: #1f2937; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; }
    .notes-section textarea { width: 100%; border: 2px solid #e5e7eb; border-radius: 12px; padding: 15px; font-size: 15px; resize: vertical; min-height: 120px; }
    .notes-section textarea:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.1); }
    .submit-area { text-align: center; padding: 30px 0; }
    .btn-submit { padding: 16px 48px; font-size: 16px; font-weight: 700; border: none; border-radius: 12px; cursor: pointer; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
    .btn-submit.primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
    .btn-submit.primary:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(102,126,234,0.4); }
    .btn-submit.cancel { background: white; color: #4b5563; border: 2px solid #e5e7eb; margin-left: 15px; }
    .btn-submit.cancel:hover { background: #f9fafb; transform: translateY(-3px); }
    @media (max-width: 768px) { .content-section { padding: 20px; } .header-section { padding: 25px; } .form-row { grid-template-columns: 1fr; } .tour-stats { flex-direction: column; } .stat-item { min-width: 100%; } }
</style>

<div class="attendance-page">
    <div class="attendance-container">
        <a href="index.php?act=job-guide" class="back-btn">
            Quay lại danh sách công việc
        </a>

        <div class="main-card">
            <div class="header-section">
                <h2>Điểm Danh Tour</h2>
                <div class="tour-info-box">
                    <h3><?= htmlspecialchars($booking['tour']['name']) ?></h3>
                    <div class="tour-stats">
                        <div class="stat-item">
                            <span><?= date('d/m/Y', strtotime($booking['start_date'])) ?> - <?= date('d/m/Y', strtotime($booking['end_date'])) ?></span>
                        </div>
                        <div class="stat-item">
                            <span><?= $booking['number_of_people'] ?> người tham gia</span>
                        </div>
                        <div class="stat-item">
                            <span>Booking <?= $booking['id'] ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-section">
                <form action="index.php?act=save-diem-danh" method="POST" id="attendanceForm">
                    <input type="hidden" name="booking_id" value="<?= $booking_id ?>">
                    <input type="hidden" name="attendance_date" value="<?= $selected_date ?>">

                    <div class="control-section">
                        <h4 class="section-title">Chọn ngày điểm danh</h4>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Ngày điểm danh</label>
                                <select onchange="window.location='index.php?act=rollcall&id=<?= $booking_id ?>&date='+this.value" style="font-size:15px;">
                                    <?php
                                    $dayCounter = 1;
                                    $vnDays = ['Monday'=>'Thứ Hai','Tuesday'=>'Thứ Ba','Wednesday'=>'Thứ Tư','Thursday'=>'Thứ Năm','Friday'=>'Thứ Sáu','Saturday'=>'Thứ Bảy','Sunday'=>'Chủ Nhật'];
                                    foreach ($validDates as $d):
                                        $obj = new DateTime($d);
                                        $label = "Ngày $dayCounter │ " . $obj->format('d/m/Y') . " (" . $vnDays[$obj->format('l')] . ")";
                                        if ($d == $today) $label .= " → HÔM NAY";
                                        $selected = ($d == $selected_date) ? 'selected' : '';
                                    ?>
                                        <option value="<?= $d ?>" <?= $selected ?>><?= $label ?></option>
                                    <?php $dayCounter++; endforeach; ?>
                                </select>

                                <?php if (!$is_today): ?>
                                    <p style="color:#dc2626; margin-top:8px; font-weight:600;">
                                        <?= $selected_date < $today ? 'Lịch sử điểm danh' : 'Chưa đến ngày' ?> – Không thể chỉnh sửa
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="quick-actions" style="margin-top:20px;">
                            <button type="button" class="btn-action btn-success" onclick="checkAll()" <?= !$can_edit ? 'disabled' : '' ?>>
                                Có mặt tất cả
                            </button>
                            <button type="button" class="btn-action btn-danger" onclick="uncheckAll()" <?= !$can_edit ? 'disabled' : '' ?>>
                                Vắng tất cả
                            </button>
                        </div>
                    </div>

                    <div class="stats-row">
                        <div class="stat-card">
                            <div class="number" id="total-people"><?= count($dataPeople) ?></div>
                            <div class="label">Tổng số người</div>
                        </div>
                        <div class="stat-card success">
                            <div class="number" id="present-count">0</div>
                            <div class="label">Có mặt</div>
                        </div>
                        <div class="stat-card danger">
                            <div class="number" id="absent-count">0</div>
                            <div class="label">Vắng mặt</div>
                        </div>
                    </div>

                    <div class="table-container">
                        <table class="attendance-table">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Họ và tên</th>
                                    <th>Số điện thoại</th>
                                    <th>Ngày sinh</th>
                                    <th>Trạng thái</th>
                                    <th>Ghi chú</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dataPeople as $index => $person):
                                    $pid = $person['id'];
                                    $data = $att_map[$pid] ?? null;
                                    $status = ($data && in_array($data['status'], ['present','absent'])) ? $data['status'] : ($can_edit ? 'present' : 'not_checked');
                                    $note   = $data['note'] ?? '';
                                ?>
                                <tr>
                                    <td style="font-weight:600;"><?= $index + 1 ?></td>
                                    <td class="person-name"><?= htmlspecialchars($person['fullname']) ?></td>
                                    <td><?= htmlspecialchars($person['phone']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($person['date'])) ?></td>
                                    <td>
                                        <div class="toggle-switch">
                                            <label class="switch">
                                                <input type="checkbox"
                                                       class="attendance-checkbox"
                                                       name="attendance[<?= $pid ?>]"
                                                       value="1"
                                                       <?= $status === 'present' ? 'checked' : '' ?>
                                                       <?= !$can_edit ? 'disabled' : '' ?>
                                                       onchange="updateStatus(<?= $pid ?>)">
                                                <span class="slider"></span>
                                            </label>
                                            <span id="status-<?= $pid ?>" class="status-badge <?= $status === 'present' ? 'badge-present' : 'badge-absent' ?>">
                                                <?= $status === 'present' ? 'Có mặt' : 'Vắng mặt' ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="note-input" name="notes[<?= $pid ?>]"
                                               value="<?= htmlspecialchars($note) ?>"
                                               placeholder="Ghi chú..." <?= !$can_edit ? 'readonly' : '' ?>>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="notes-section">
                        <label>Ghi chú chung (<?= date('d/m/Y', strtotime($selected_date)) ?>)</label>
                        <textarea name="general_notes" placeholder="Thời tiết, sự cố, hoạt động đặc biệt..." <?= !$can_edit ? 'readonly' : '' ?>></textarea>
                    </div>

                    <div class="submit-area">
                        <?php if ($can_edit): ?>
                            <button type="submit" class="btn-submit primary">
                                Lưu điểm danh hôm nay
                            </button>
                        <?php else: ?>
                            <div style="padding:25px; background:#fffbeb; border-radius:12px; color:#92400e; font-weight:600; text-align:center; border:1px solid #fcd34d;">
                                Chỉ được điểm danh vào đúng hôm nay (<?= date('d/m/Y') ?>)<br>
                                Bạn đang xem ngày <?= date('d/m/Y', strtotime($selected_date)) ?>
                            </div>
                        <?php endif; ?>
                        <a href="index.php?act=job-guide" class="btn-submit cancel">Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function updateStatistics() {
    const boxes = document.querySelectorAll('.attendance-checkbox');
    let present = 0;
    boxes.forEach(b => { if (b.checked) present++; });
    document.getElementById('present-count').textContent = present;
    document.getElementById('absent-count').textContent = boxes.length - present;
}

function checkAll() {
    document.querySelectorAll('.attendance-checkbox').forEach(cb => cb.checked = true);
    updateStatistics();
    document.querySelectorAll('.status-badge').forEach(b => {
        b.textContent = 'Có mặt';
        b.className = 'status-badge badge-present';
    });
}

function uncheckAll() {
    document.querySelectorAll('.attendance-checkbox').forEach(cb => cb.checked = false);
    updateStatistics();
    document.querySelectorAll('.status-badge').forEach(b => {
        b.textContent = 'Vắng mặt';
        b.className = 'status-badge badge-absent';
    });
}

function updateStatus(id) {
    const cb = document.querySelector(`input[name="attendance[${id}]"]`);
    const badge = document.getElementById('status-' + id);
    badge.textContent = cb.checked ? 'Có mặt' : 'Vắng mặt';
    badge.className = cb.checked ? 'status-badge badge-present' : 'status-badge badge-absent';
    updateStatistics();
}

window.onload = updateStatistics;
</script>