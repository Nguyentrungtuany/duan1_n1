<div class="container mt-4">
    <h2 class="text-center mb-3">Danh sách hướng dẫn viên</h2>
    <a href="?act=admin_guide_create" class="btn btn-primary mb-3">+ Thêm hướng dẫn viên</a>
    <table class="table table-bordered">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Họ tên</th>
                <th>Chuyên môn</th>
                <th>Kinh nghiệm</th>
                <th>Ngôn ngữ</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($guides as $g): ?>
                <tr>
                    <td><?= $g['id'] ?></td>
                    <td><?= htmlspecialchars($g['full_name']) ?></td>
                    <td><?= htmlspecialchars($g['specialization']) ?></td>
                    <td><?= $g['experience_years'] ?> năm</td>
                    <td><?= htmlspecialchars($g['languages']) ?></td>
                    <td><?= htmlspecialchars($g['status']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
