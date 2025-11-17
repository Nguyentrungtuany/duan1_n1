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
						<li class="odd"><a href="#">
								<div class="user_img"><img src="images/4.jpg" alt=""></div>
								<div class="notification_desc">
									<p>Lorem ipsum dolor amet </p>
									<p><span>1 hour ago</span></p>
								</div>
								<div class="clearfix"></div>
							</a></li>
						<li><a href="#">
								<div class="user_img"><img src="images/3.jpg" alt=""></div>
								<div class="notification_desc">
									<p>Lorem ipsum dolor amet </p>
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
						<li><a href="#">
								<div class="user_img"><img src="images/4.jpg" alt=""></div>
								<div class="notification_desc">
									<p>Lorem ipsum dolor amet</p>
									<p><span>1 hour ago</span></p>
								</div>
								<div class="clearfix"></div>
							</a></li>
						<li class="odd"><a href="#">
								<div class="user_img"><img src="images/1.jpg" alt=""></div>
								<div class="notification_desc">
									<p>Lorem ipsum dolor amet </p>
									<p><span>1 hour ago</span></p>
								</div>
								<div class="clearfix"></div>
							</a></li>
						<li><a href="#">
								<div class="user_img"><img src="images/3.jpg" alt=""></div>
								<div class="notification_desc">
									<p>Lorem ipsum dolor amet </p>
									<p><span>1 hour ago</span></p>
								</div>
								<div class="clearfix"></div>
							</a></li>
						<li>
							<div class="notification_bottom">
								<a href="#">See all notifications</a>
							</div>
						</li>
					</ul>
				</li>
				<li class="dropdown head-dpdn">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-tasks"></i><span class="badge blue1">8</span></a>
					<ul class="dropdown-menu">
						<li>
							<div class="notification_header">
								<h3>You have 8 pending task</h3>
							</div>
						</li>
						<li><a href="#">
								<div class="task-info">
									<span class="task-desc">Database update</span><span class="percentage">40%</span>
									<div class="clearfix"></div>
								</div>
								<div class="progress progress-striped active">
									<div class="bar yellow" style="width:40%;"></div>
								</div>
							</a></li>
						<li><a href="#">
								<div class="task-info">
									<span class="task-desc">Dashboard done</span><span class="percentage">90%</span>
									<div class="clearfix"></div>
								</div>
								<div class="progress progress-striped active">
									<div class="bar green" style="width:90%;"></div>
								</div>
							</a></li>
						<li><a href="#">
								<div class="task-info">
									<span class="task-desc">Mobile App</span><span class="percentage">33%</span>
									<div class="clearfix"></div>
								</div>
								<div class="progress progress-striped active">
									<div class="bar red" style="width: 33%;"></div>
								</div>
							</a></li>
						<li><a href="#">
								<div class="task-info">
									<span class="task-desc">Issues fixed</span><span class="percentage">80%</span>
									<div class="clearfix"></div>
								</div>
								<div class="progress progress-striped active">
									<div class="bar  blue" style="width: 80%;"></div>
								</div>
							</a></li>
						<li>
							<div class="notification_bottom">
								<a href="#">See all pending tasks</a>
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
			<form class="input">
				<input class="sb-search-input input__field--madoka" placeholder="Search..." type="search" id="input-31" />
				<label class="input__label" for="input-31">
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
			<h2 class="title1">Tables</h2>
			<!-- <div class="panel-body widget-shadow">
				<h4>Basic Table:</h4>
				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Username</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th scope="row">1</th>
							<td>Mark</td>
							<td>Otto</td>
							<td>@mdo</td>
						</tr>
						<tr>
							<th scope="row">2</th>
							<td>Jacob</td>
							<td>Thornton</td>
							<td>@fat</td>
						</tr>
						<tr>
							<th scope="row">3</th>
							<td>Larry</td>
							<td>the Bird</td>
							<td>@twitter</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="bs-example widget-shadow" data-example-id="bordered-table">
				<h4>Bordered Basic Table:</h4>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>#</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Username</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th scope="row">1</th>
							<td>Mark</td>
							<td>Otto</td>
							<td>@mdo</td>
						</tr>
						<tr>
							<th scope="row">2</th>
							<td>Jacob</td>
							<td>Thornton</td>
							<td>@fat</td>
						</tr>
						<tr>
							<th scope="row">3</th>
							<td>Larry</td>
							<td>the Bird</td>
							<td>@twitter</td>
						</tr>
					</tbody>
				</table>
			</div> -->
			<div class="bs-example widget-shadow" data-example-id="hoverable-table">
				<h4>Quản lý Tour:</h4>
				<div class="mt-3">
					<a href="index.php?act=addqltour" class="btn btn-success btn-sm">
						<i class="fa fa-plus"></i> Thêm mới
					</a>
				</div>

				<table class="table table-hover">
					<thead>
						<tr>
							<th>id</th>
							<th>Name</th>
							<th>Category</th>
							<th>Description</th>
							<th>start_date</th>
							<th>end_date</th>
							<th>price</th>
							<th>status</th>
							<th>created_at</th>
							<th>updated_at</th>
						</tr>
					</thead>
					<?php foreach ($DataQltour as $data): ?>
						<tbody>
							<tr>
								<th scope="row"><?php echo $data['id']; ?></th>
								<td><?php echo $data['name']; ?></td>
								<td><?php echo $data['category']; ?></td>
								<td><?php echo $data['description']; ?></td>
								<td><?php echo $data['start_date']; ?></td>
								<td><?php echo $data['end_date']; ?></td>
								<td><?php echo $data['price']; ?></td>
								<td><?php echo $data['status']; ?></td>
								<td><?php echo $data['created_at']; ?></td>
								<td><?php echo $data['updated_at']; ?></td>
								<td>
									<a href="index.php?act=editqltour&id=<?php echo $data['id']; ?>" class="btn btn-primary btn-sm">
										<i class="fa fa-edit"></i> Sửa
									</a>
									<a href="index.php?act=deleteqltour&id=<?php echo $data['id']; ?>" class="btn btn-danger btn-sm">
										<i class="fa fa-edit"></i> xóa
									</a>
								</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
				</table>

			</div>
			<!-- <div class="bs-example widget-shadow" data-example-id="contextual-table">
				<h4>Colored Rows Table:</h4>
				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>Column heading</th>
							<th>Column heading</th>
							<th>Column heading</th>
						</tr>
					</thead>
					<tbody>
						<tr class="active">
							<th scope="row">1</th>
							<td>Column content</td>
							<td>Column content</td>
							<td>Column content</td>
						</tr>
						<tr>
							<th scope="row">2</th>
							<td>Column content</td>
							<td>Column content</td>
							<td>Column content</td>
						</tr>
						<tr class="success">
							<th scope="row">3</th>
							<td>Column content</td>
							<td>Column content</td>
							<td>Column content</td>
						</tr>
						<tr>
							<th scope="row">4</th>
							<td>Column content</td>
							<td>Column content</td>
							<td>Column content</td>
						</tr>
						<tr class="info">
							<th scope="row">5</th>
							<td>Column content</td>
							<td>Column content</td>
							<td>Column content</td>
						</tr>
						<tr>
							<th scope="row">6</th>
							<td>Column content</td>
							<td>Column content</td>
							<td>Column content</td>
						</tr>
						<tr class="warning">
							<th scope="row">7</th>
							<td>Column content</td>
							<td>Column content</td>
							<td>Column content</td>
						</tr>
						<tr>
							<th scope="row">8</th>
							<td>Column content</td>
							<td>Column content</td>
							<td>Column content</td>
						</tr>
						<tr class="danger">
							<th scope="row">9</th>
							<td>Column content</td>
							<td>Column content</td>
							<td>Column content</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="table-responsive bs-example widget-shadow">
				<h4>Responsive Table:</h4>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>#</th>
							<th>Table heading</th>
							<th>Table heading</th>
							<th>Table heading</th>
							<th>Table heading</th>
							<th>Table heading</th>
							<th>Table heading</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th scope="row">1</th>
							<td>Table cell</td>
							<td>Table cell</td>
							<td>Table cell</td>
							<td>Table cell</td>
							<td>Table cell</td>
							<td>Table cell</td>
						</tr>
						<tr>
							<th scope="row">2</th>
							<td>Table cell</td>
							<td>Table cell</td>
							<td>Table cell</td>
							<td>Table cell</td>
							<td>Table cell</td>
							<td>Table cell</td>
						</tr>
						<tr>
							<th scope="row">3</th>
							<td>Table cell</td>
							<td>Table cell</td>
							<td>Table cell</td>
							<td>Table cell</td>
							<td>Table cell</td>
							<td>Table cell</td>
						</tr>
					</tbody>
				</table>
			</div> -->
		</div>
	</div>
</div>
<?php
require_once __DIR__ . '/../layout/footer.php';
?>