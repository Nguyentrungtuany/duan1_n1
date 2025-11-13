<?php
require_once __DIR__ . '/../layout/header.php';

?>
<!-- header-starts -->
<div class="sticky-header header-section ">
	<div class="header-left">
		<!--toggle button start-->
		<button id="showLeftPush"><i class="fa fa-bars"></i></button>
		<!--toggle button end-->
		<div class="profile_details_left"><!--notifications of menu start -->
			<ul class="nofitications-dropdown">
				<li class="dropdown head-dpdn">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-envelope"></i><span class="badge">4</span></a>
					<ul class="dropdown-menu">
						<li>
							<div class="notification_header">
								<h3>You have 3 new messages</h3>
							</div>
						</li>
						<li><a href="#">
								<div class="user_img"><img src="images/1.jpg" alt=""></div>
								<div class="notification_desc">
									<p>Lorem ipsum dolor amet</p>
									<p><span>1 hour ago</span></p>
								</div>
								<div class="clearfix"></div>
							</a></li>
						<li>
							<div class="notification_bottom">
								<a href="#">See all messages</a>
							</div>
						</li>
					</ul>
				</li>
				<li class="dropdown head-dpdn">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bell"></i><span class="badge blue">4</span></a>
					<ul class="dropdown-menu">
						<li>
							<div class="notification_header">
								<h3>You have 3 new notification</h3>
							</div>
						</li>
						<li>
							<div class="notification_bottom">
								<a href="#">See all notifications</a>
							</div>
						</li>
					</ul>
				</li>
			</ul>
			<div class="clearfix"> </div>
		</div>
		<!--notification menu end -->
		<div class="clearfix"> </div>
	</div>
	<div class="header-right">
		<!--search-box-->
		<div class="search-box">
			<form class="input" action="index.php" method="GET">
				<input type="hidden" name="controller" value="user">
				<input type="hidden" name="action" value="search">
				<input class="sb-search-input input__field--madoka" placeholder="Tìm kiếm tài khoản..." type="search" name="keyword" value="<?php echo $_GET['keyword'] ?? ''; ?>" />
				<label class="input__label">
					<svg class="graphic" width="100%" height="100%" viewBox="0 0 404 77" preserveAspectRatio="none">
						<path d="m0,0l404,0l0,77l-404,0l0,-77z" />
					</svg>
				</label>
			</form>
		</div><!--//end-search-box-->

		<div class="profile_details">
			<ul>
				<li class="dropdown profile_details_drop">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<div class="profile_img">
							<span class="prfil-img"><img src="images/2.jpg" alt=""> </span>
							<div class="user-name">
								<p>Admin Name</p>
								<span>Administrator</span>
							</div>
							<i class="fa fa-angle-down lnr"></i>
							<i class="fa fa-angle-up lnr"></i>
							<div class="clearfix"></div>
						</div>
					</a>
					<ul class="dropdown-menu drp-mnu">
						<li> <a href="#"><i class="fa fa-cog"></i> Settings</a> </li>
						<li> <a href="#"><i class="fa fa-user"></i> My Account</a> </li>
						<li> <a href="#"><i class="fa fa-suitcase"></i> Profile</a> </li>
						<li> <a href="#"><i class="fa fa-sign-out"></i> Logout</a> </li>
					</ul>
				</li>
			</ul>
		</div>
		<div class="clearfix"> </div>
	</div>
	<div class="clearfix"> </div>
</div>
<!-- //header-ends -->

<!-- main content start-->
<div id="page-wrapper">
	<div class="main-page">
		<div class="tables">
			<h2 class="title1">Quản lý tài khoản</h2>
			<div class="bs-example widget-shadow" data-example-id="hoverable-table">
				<h4>Danh sách tài khoản</h4>
				<div class="mb-3">
					<a href="<?= BASE_URL ?>?act=user-create" class="btn btn-sm btn-primary">
						<i class="fa fa-plus"></i> Thêm mới
					</a>
				</div>

				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Tên đăng nhập</th>
								<th>Email</th>
								<th>Full Name</th>
								<th>Role</th>
								<th>Phone</th>
								<th>Ngày tạo</th>
								<th>Trạng thái</th>
								<th>Ngày cập nhật</th>
								<th>Hành động</th>
							</tr>
						</thead>
						<tbody>
							<?php if (empty($users)): ?>
								<tr>
									<td colspan="8" class="text-center">
										<i class="fa fa-info-circle"></i> Không có dữ liệu
									</td>
								</tr>
							<?php else: ?>
								<?php foreach ($users as $user): ?>
									<tr>
										<th scope="row"><?php echo $user['id']; ?></th>
										<td><?php echo htmlspecialchars($user['username']); ?></td>
										<td><?php echo htmlspecialchars($user['email']); ?></td>
										<td><?php echo htmlspecialchars($user['full_name']); ?></td>
										<td>
											<?php if ($user['role'] === 'admin'): ?>
												<span class="badge badge-danger">Admin</span>
											<?php else: ?>
												<span class="badge badge-primary">User</span>
											<?php endif; ?>
										</td>
										<td><?php echo htmlspecialchars($user['phone']); ?></td>

										<td>
											<?php
											if (isset($user['created_at'])) {
												echo date('d/m/Y H:i', strtotime($user['created_at']));
											} else {
												echo 'N/A';
											}
											?>
										</td>
										<td>
											<?php if ($user['status'] === 'active'): ?>
												<span class="badge badge-success">Hoạt động</span>
											<?php elseif ($user['status'] === 'inactive'): ?>
												<span class="badge badge-secondary">Bị khóa</span>
											<?php endif; ?>

										</td>
										<td>
											<a href="<?= BASE_URL ?>?act=admin-edit-user&id=<?= $user['id'] ?>" class="btn btn-sm btn-primary">
												<i class="fa fa-edit"></i> Sửa
											</a>
											<a href="<?= BASE_URL ?>?act=admin-delete-user&id=<?= $user['id'] ?>"
												class="btn btn-sm btn-danger"
												onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản này không?')">
												<i class="fa fa-trash"></i> Xóa
											</a>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>

		</div>
	</div>
</div>
<?php
require_once __DIR__ . '/../layout/footer.php';
?>