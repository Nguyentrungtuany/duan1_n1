<div class="container mt-4">
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
        <button class="btn btn-success w-100">Lưu</button>
    </form>
</div>
