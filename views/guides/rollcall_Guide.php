<?php
// require_once 'views/layout/guides/header.php';

// Decode JSON data
if (isset($booking['tour']) && is_string($booking['tour'])) {
    $booking['tour'] = json_decode($booking['tour'], true);
}
if (isset($booking['customer']) && is_string($booking['customer'])) {
    $booking['customer'] = json_decode($booking['customer'], true);
}
if (isset($booking['people']) && is_string($booking['people'])) {
    $booking['people'] = json_decode($booking['people'], true);
}
?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .attendance-page {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 20px;
    }

    .attendance-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .back-btn {
        background: white;
        color: #333;
        border: none;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 20px;
        text-decoration: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .back-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        color: #667eea;
        text-decoration: none;
    }

    .main-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .header-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 40px;
        color: white;
    }

    .header-section h2 {
        margin: 0 0 20px 0;
        font-size: 32px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .tour-info-box {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 25px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .tour-info-box h3 {
        margin: 0 0 15px 0;
        font-size: 24px;
        font-weight: 600;
    }

    .tour-stats {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 10px;
        background: rgba(255, 255, 255, 0.1);
        padding: 12px 16px;
        border-radius: 10px;
        flex: 1;
        min-width: 200px;
    }

    .stat-item i {
        font-size: 20px;
    }

    .content-section {
        padding: 40px;
    }

    .control-section {
        background: #f9fafb;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 30px;
        border: 2px solid #e5e7eb;
    }

    .section-title {
        margin: 0 0 20px 0;
        color: #1f2937;
        font-size: 18px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 25px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group label {
        font-weight: 600;
        color: #4b5563;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .form-group input,
    .form-group select {
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 15px;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .quick-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .btn-action {
        padding: 12px 24px;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-success {
        background: #10b981;
        color: white;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-primary {
        background: #667eea;
        color: white;
    }

    .btn-warning {
        background: #f59e0b;
        color: white;
    }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 15px;
        margin-bottom: 25px;
    }

    .stat-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .stat-card.success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .stat-card.danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    .stat-card .number {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .stat-card .label {
        font-size: 13px;
        opacity: 0.9;
    }

    .table-container {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
    }

    .attendance-table {
        width: 100%;
        border-collapse: collapse;
    }

    .attendance-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .attendance-table thead th {
        color: white;
        font-weight: 600;
        padding: 18px 15px;
        text-align: center;
        font-size: 14px;
    }

    .attendance-table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #f3f4f6;
    }

    .attendance-table tbody tr:hover {
        background: #f9fafb;
    }

    .attendance-table tbody td {
        padding: 18px 15px;
        vertical-align: middle;
        color: #4b5563;
        text-align: center;
    }

    .person-name {
        font-weight: 600;
        color: #1f2937;
        font-size: 15px;
        text-align: left;
    }

    .toggle-switch {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }

    .switch {
        position: relative;
        width: 50px;
        height: 26px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.4s;
        border-radius: 26px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50%;
    }

    .switch input:checked+.slider {
        background-color: #10b981;
    }

    .switch input:checked+.slider:before {
        transform: translateX(24px);
    }

    .status-badge {
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
    }

    .badge-present {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-absent {
        background: #fee2e2;
        color: #991b1b;
    }

    .note-input {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 14px;
        width: 100%;
        transition: all 0.3s ease;
    }

    .note-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .notes-section {
        background: #f9fafb;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
    }

    .notes-section label {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .notes-section textarea {
        width: 100%;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 15px;
        font-size: 15px;
        resize: vertical;
        min-height: 120px;
        font-family: inherit;
    }

    .notes-section textarea:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .submit-area {
        text-align: center;
        padding: 30px 0;
    }

    .btn-submit {
        padding: 16px 48px;
        font-size: 16px;
        font-weight: 700;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-submit.primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-submit.primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }

    .btn-submit.cancel {
        background: white;
        color: #4b5563;
        border: 2px solid #e5e7eb;
        margin-left: 15px;
    }

    .btn-submit.cancel:hover {
        background: #f9fafb;
        transform: translateY(-3px);
    }

    @media (max-width: 768px) {
        .content-section {
            padding: 20px;
        }

        .header-section {
            padding: 25px;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .tour-stats {
            flex-direction: column;
        }

        .stat-item {
            min-width: 100%;
        }

        .attendance-table {
            font-size: 13px;
        }

        .attendance-table thead th,
        .attendance-table tbody td {
            padding: 12px 8px;
        }
    }
</style>

<div class="attendance-page">
    <div class="attendance-container">
        <!-- Back Button -->
        <a href="index.php?act=job-guide" class="back-btn">
            <i class="fa fa-arrow-left"></i>
            <span>Quay lại danh sách công việc</span>
        </a>

        <div class="main-card">
            <!-- Header -->
            <div class="header-section">
                <h2>
                    <i class="fa fa-check-circle"></i>
                    Điểm Danh Tour
                </h2>

                <div class="tour-info-box">
                    <h3>
                        <i class="fa fa-map-signs"></i>
                        <?= htmlspecialchars($booking['tour']['name']) ?>
                    </h3>
                    <div class="tour-stats">
                        <div class="stat-item">
                            <i class="fa fa-calendar"></i>
                            <span><?= date('d/m/Y', strtotime($booking['start_date'])) ?> - <?= date('d/m/Y', strtotime($booking['end_date'])) ?></span>
                        </div>
                        <div class="stat-item">
                            <i class="fa fa-users"></i>
                            <span><?= $booking['number_of_people'] ?> người tham gia</span>
                        </div>
                        <div class="stat-item">
                            <i class="fa fa-hashtag"></i>
                            <span>Booking <?= $booking['id'] ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="content-section">
                <form action="index.php?act=save-diem-danh" method="POST" id="attendanceForm">
                    <input type="hidden" name="booking_id" value="<?= $booking_id ?>">

                    <!-- Controls -->
                    <div class="control-section">
                        <h4 class="section-title">
                            <i class="fa fa-cog"></i>
                            Thiết lập điểm danh
                        </h4>

                        <div class="form-row">
                            <div class="form-group">
    <label>
        <i class="fa fa-calendar-check-o"></i>
        Ngày điểm danh
    </label>
    <select id="attendance_date" name="attendance_date" required style="font-size: 15px;">
        <?php
        $startDate = new DateTime($booking['start_date']);
        $endDate   = new DateTime($booking['end_date']);
        $endDate->modify('+1 day'); // để bao gồm cả ngày cuối
        $period    = new DatePeriod($startDate, new DateInterval('P1D'), $endDate);

        $today = date('Y-m-d');
        $vietnameseDays = [
            'Monday'    => 'Thứ Hai',
            'Tuesday'   => 'Thứ Ba',
            'Wednesday' => 'Thứ Tư',
            'Thursday'  => 'Thứ Năm',
            'Friday'    => 'Thứ Sáu',
            'Saturday'  => 'Thứ Bảy',
            'Sunday'    => 'Chủ Nhật'
        ];

        // Giữ ngày đã chọn nếu form bị submit lại (lỗi validate chẳng hạn)
        $selectedDate = $_POST['attendance_date'] ?? $today;

        foreach ($period as $date) {
            $dateStr   = $date->format('Y-m-d');
            $dayName   = $vietnameseDays[$date->format('l')];
            $display   = $date->format('d/m/Y') . " - " . $dayName;

            $isToday   = ($dateStr === $today);
            $isFirst   = ($dateStr === $booking['start_date']);
            $isLast    = ($dateStr === $booking['end_date']);

            // Thêm nhãn đặc biệt
            $label = '';
            if ($isToday)   $label = ' → Hôm nay';
            if ($isFirst)   $label = ' → Ngày đầu tour';
            if ($isLast && !$isToday) $label = ' → Ngày cuối tour';
            if ($isFirst && $isLast)  $label = ' → Tour 1 ngày';

            // Ưu tiên chọn: hôm nay → nếu không có thì ngày đầu tour
            $selected = '';
            if (isset($_POST['attendance_date'])) {
                $selected = ($dateStr === $_POST['attendance_date']) ? 'selected' : '';
            } else {
                if ($isToday && $dateStr >= $booking['start_date'] && $dateStr <= $booking['end_date']) {
                    $selected = 'selected';
                } elseif (!$selected && $isFirst) {
                    $selected = 'selected';
                }
            }

            echo "<option value=\"{$dateStr}\" {$selected}>{$display}{$label}</option>";
        }
        ?>
    </select>
</div>
                            <div class="form-group">
                                <label>
                                    <i class="fa fa-clock-o"></i>
                                    Buổi
                                </label>
                                <select id="session" name="session" required>
                                    <option value="morning">🌅 Sáng</option>
                                    <option value="afternoon">☀️ Chiều</option>
                                    <option value="evening">🌙 Tối</option>
                                    <option value="fullday" selected>📅 Cả ngày</option>
                                </select>
                            </div>

                            <!-- <div class="form-group">
                                <label>
                                    <i class="fa fa-map-marker"></i>
                                    Địa điểm
                                </label>
                                <input type="text"
                                    id="location"
                                    name="location"
                                    placeholder="Nhập địa điểm điểm danh"
                                    >
                            </div> -->
                        </div>

                        <h4 class="section-title" style="margin-top: 25px;">
                            <i class="fa fa-bolt"></i>
                            Hành động nhanh
                        </h4>
                        <div class="quick-actions">
                            <button type="button" class="btn-action btn-success" onclick="checkAll()">
                                <i class="fa fa-check"></i>
                                Có mặt tất cả
                            </button>
                            <button type="button" class="btn-action btn-danger" onclick="uncheckAll()">
                                <i class="fa fa-times"></i>
                                Vắng tất cả
                            </button>
                            <!-- <button type="button" class="btn-action btn-primary" onclick="toggleAll()">
                                <i class="fa fa-refresh"></i>
                                Đảo ngược
                            </button>
                            <button type="button" class="btn-action btn-warning" onclick="exportData()">
                                <i class="fa fa-download"></i>
                                Xuất Excel
                            </button> -->
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="stats-row">
                        <div class="stat-card">
                            <div class="number" id="total-people"><?= count($dataPeople) ?></div>
                            <div class="label">Tổng số người</div>
                        </div>
                        <div class="stat-card success">
                            <div class="number" id="present-count"><?= count($dataPeople) ?></div>
                            <div class="label">Có mặt</div>
                        </div>
                        <div class="stat-card danger">
                            <div class="number" id="absent-count">0</div>
                            <div class="label">Vắng mặt</div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-container">
                        <table class="attendance-table">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">STT</th>
                                    <th style="width: 20%;">Họ và tên</th>
                                    <th style="width: 12%;">Số điện thoại</th>
                                    <th style="width: 10%;">Ngày sinh</th>
                                    <th style="width: 15%;">Trạng thái</th>
                                    <th style="width: 38%;">Ghi chú</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dataPeople as $index => $person): ?>
                                    <tr>
                                        <td style="font-weight: 600;">
                                            <?= $index + 1 ?>
                                        </td>
                                        <td>
                                            <div class="person-name">
                                                <?= htmlspecialchars($person['fullname']) ?>
                                            </div>
                                            <input type="hidden" name="people_ids[]" value="<?= $person['id'] ?>">
                                        </td>
                                        <td><?= htmlspecialchars($person['phone']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($person['date'])) ?></td>
                                        <td>
                                            <div class="toggle-switch">
                                                <label class="switch">
                                                    <input type="checkbox"
                                                        class="attendance-checkbox"
                                                        name="attendance[<?= $person['id'] ?>]"
                                                        value="1"
                                                        checked
                                                        onchange="updateStatus(<?= $person['id'] ?>)">
                                                    <span class="slider"></span>
                                                </label>
                                                <span id="status-<?= $person['id'] ?>" class="status-badge badge-present">
                                                    Có mặt
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text"
                                                class="note-input"
                                                name="notes[<?= $person['id'] ?>]"
                                                placeholder="Nhập ghi chú...">
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Notes -->
                    <div class="notes-section">
                        <label>
                            <i class="fa fa-comment"></i>
                            Ghi chú chung
                        </label>
                        <textarea name="general_notes"
                            placeholder="Nhập ghi chú chung về buổi điểm danh (thời tiết, sự cố, hoạt động đặc biệt...)"></textarea>
                    </div>

                    <!-- Submit -->
                    <div class="submit-area">
                        <button type="submit" class="btn-submit primary">
                            <i class="fa fa-save"></i>
                            Lưu điểm danh
                        </button>
                        <a href="index.php?act=job-guide" class="btn-submit cancel">
                            <i class="fa fa-times"></i>
                            Hủy bỏ
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function updateStatistics() {
        const checkboxes = document.querySelectorAll('.attendance-checkbox');
        const presentCount = Array.from(checkboxes).filter(cb => cb.checked).length;
        const absentCount = checkboxes.length - presentCount;

        document.getElementById('present-count').textContent = presentCount;
        document.getElementById('absent-count').textContent = absentCount;
    }

    function checkAll() {
        document.querySelectorAll('.attendance-checkbox').forEach(checkbox => {
            checkbox.checked = true;
            const personId = checkbox.name.match(/\d+/)[0];
            updateStatus(personId);
        });
        updateStatistics();
    }

    function uncheckAll() {
        document.querySelectorAll('.attendance-checkbox').forEach(checkbox => {
            checkbox.checked = false;
            const personId = checkbox.name.match(/\d+/)[0];
            updateStatus(personId);
        });
        updateStatistics();
    }

    function toggleAll() {
        document.querySelectorAll('.attendance-checkbox').forEach(checkbox => {
            checkbox.checked = !checkbox.checked;
            const personId = checkbox.name.match(/\d+/)[0];
            updateStatus(personId);
        });
        updateStatistics();
    }

    function updateStatus(personId) {
        const checkbox = document.querySelector(`input[name="attendance[${personId}]"]`);
        const statusBadge = document.getElementById(`status-${personId}`);

        if (checkbox.checked) {
            statusBadge.textContent = 'Có mặt';
            statusBadge.className = 'status-badge badge-present';
        } else {
            statusBadge.textContent = 'Vắng mặt';
            statusBadge.className = 'status-badge badge-absent';
        }

        updateStatistics();
    }

    function exportData() {
        alert('Tính năng xuất Excel đang được phát triển!');
    }

    document.getElementById('attendanceForm').addEventListener('submit', function(e) {
        const date = document.getElementById('attendance_date').value;
        const session = document.getElementById('session').value;

        if (!date || !session) {
            e.preventDefault();
            alert('⚠️ Vui lòng chọn ngày và buổi điểm danh!');
            return false;
        }

        const presentCount = document.getElementById('present-count').textContent;
        const absentCount = document.getElementById('absent-count').textContent;

        if (!confirm(`Xác nhận lưu điểm danh?\n\n✅ Có mặt: ${presentCount} người\n❌ Vắng mặt: ${absentCount} người`)) {
            e.preventDefault();
            return false;
        }
    });

    updateStatistics();
</script>

<?php
// require_once 'views/layout/guides/footer.php';
?>