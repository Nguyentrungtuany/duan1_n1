<?php require_once __DIR__ . '/../layout/admin/header.php'; ?>

<div class="main-content">
    <div class="container-fluid">
        <div class="page-header">
            <h1>Tài Khoản Của Tôi</h1>
        </div>

        <?php if ($user): ?>
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card">
                        <div class="card-header">
                            <h3><i class="fa fa-user"></i> Thông Tin Cá Nhân</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td width="200"><strong>Tên đăng nhập:</strong></td>
                                        <td><?= htmlspecialchars($user['username']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Họ và tên:</strong></td>
                                        <td><?= htmlspecialchars($user['full_name'] ?? 'Chưa cập nhật') ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Số điện thoại:</strong></td>
                                        <td><?= htmlspecialchars($user['phone'] ?? 'Chưa cập nhật') ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Địa chỉ:</strong></td>
                                        <td><?= htmlspecialchars($user['address'] ?? 'Chưa cập nhật') ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Vai trò:</strong></td>
                                        <td>
                                            <?php
                                            $role = $user['role'] ?? 'guide';
                                            $roleText = match ($role) {
                                                'admin' => 'Quản trị viên',
                                                'guide' => 'Hướng dẫn viên',
                                                'customer' => 'Khách hàng',
                                                default => ucfirst($role)
                                            };
                                            ?>
                                            <span class="badge badge-<?= $role === 'admin' ? 'danger' : 'info' ?>">
                                                <?= $roleText ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Trạng thái:</strong></td>
                                        <td>
                                            <?php
                                            $status = $user['status'] ?? 'active';
                                            $statusText = $status === 'active' ? 'Hoạt động' : 'Vô hiệu hóa';
                                            ?>
                                            <span class="badge badge-<?= $status === 'active' ? 'success' : 'secondary' ?>">
                                                <?= $statusText ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Ngày tạo:</strong></td>
                                        <td><?= isset($user['created_at']) ? date('d/m/Y H:i', strtotime($user['created_at'])) : 'Không rõ' ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                <i class="fa fa-exclamation-triangle"></i> Bạn chưa đăng nhập. Vui lòng <a href="?act=login">đăng nhập</a> để xem thông tin tài khoản.
            </div>
        <?php endif; ?>
    </div>
</div>