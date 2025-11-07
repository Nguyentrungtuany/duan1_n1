<?php
require_once __DIR__ . '/layout/header.php';
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
		<div class="forms validation">
			<h2 class="title1">Validation Forms :</h2>
			<div class="form-three widget-shadow">
				<div data-example-id="form-validation-states">
					<form>
						<div class="form-group has-success"> <label class="control-label" for="inputSuccess1">Input with success</label> <input type="text" class="form-control" id="inputSuccess1" aria-describedby="helpBlock2"> <span id="helpBlock2" class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span> </div>
						<div class="form-group has-warning"> <label class="control-label" for="inputWarning1">Input with warning</label> <input type="text" class="form-control" id="inputWarning1"> </div>
						<div class="form-group has-error"> <label class="control-label" for="inputError1">Input with error</label> <input type="text" class="form-control" id="inputError1"> </div>
						<div class="has-success">
							<div class="checkbox"> <label> <input type="checkbox" id="checkboxSuccess" value="option1"> Checkbox with success </label> </div>
						</div>
						<div class="has-warning">
							<div class="checkbox"> <label> <input type="checkbox" id="checkboxWarning" value="option1"> Checkbox with warning </label> </div>
						</div>
						<div class="has-error">
							<div class="checkbox"> <label> <input type="checkbox" id="checkboxError" value="option1"> Checkbox with error </label> </div>
						</div>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms">
					<div class="form-title">
						<h4>Register Form :</h4>
					</div>
					<div class="form-body">
						<form data-toggle="validator">
							<div class="form-group">
								<input type="text" class="form-control" id="inputName" placeholder="Username" required>
							</div>
							<div class="form-group has-feedback">
								<input type="email" class="form-control" id="inputEmail" placeholder="Email" data-error="Bruh, that email address is invalid" required>
								<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
								<span class="help-block with-errors">Please enter a valid email address</span>
							</div>
							<div class="form-group">
								<input type="password" data-toggle="validator" data-minlength="6" class="form-control" id="inputPassword" placeholder="Password" required>
								<span class="help-block">Minimum of 6 characters</span>
							</div>
							<div class="form-group">
								<input type="password" class="form-control" id="inputPasswordConfirm" data-match="#inputPassword" data-match-error="Whoops, these don't match" placeholder="Confirm password" required>
								<div class="help-block with-errors"></div>
							</div>
							<div class="form-group">
								<div class="radio">
									<label>
										<input type="radio" name="gender" required>
										Female
									</label>
								</div>
								<div class="radio">
									<label>
										<input type="radio" name="gender" required>
										Male
									</label>
								</div>
							</div>
							<div class="form-group">
								<div class="checkbox">
									<label>
										<input type="checkbox" id="terms" data-error="Before you wreck yourself" required>
										I have read and accept terms of use.
									</label>
									<div class="help-block with-errors"></div>
								</div>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary disabled">Submit</button>
							</div>
						</form>
					</div>
				</div>
				<div class="col-md-6 validation-grids validation-grids-right">
					<div class="widget-shadow" data-example-id="basic-forms">
						<div class="form-title">
							<h4>Login form :</h4>
						</div>
						<div class="form-body">
							<form data-toggle="validator">
								<div class="form-group has-feedback">
									<input type="email" class="form-control" id="inputEmail" placeholder="Enter Your Email" data-error="Bruh, that email address is invalid" required>
									<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
								</div>
								<div class="form-group">
									<input type="password" data-toggle="validator" data-minlength="6" class="form-control" id="inputPassword" placeholder="Password" required>
								</div>
								<div class="bottom">
									<div class="form-group">
										<div class="checkbox">
											<label>
												<input type="checkbox" id="terms" data-error="Before you wreck yourself" required>
												Remember me
											</label>
											<div class="help-block with-errors"></div>
										</div>
									</div>
									<div class="form-group">
										<button type="submit" class="btn btn-primary disabled">Login</button>
									</div>
									<div class="clearfix"> </div>
								</div>
							</form>
						</div>
					</div>
					<div class="inline-form widget-shadow">
						<div class="form-title">
							<h4>Recover form :</h4>
						</div>
						<div class="form-body">
							<form data-toggle="validator">
								<div class="form-group has-feedback">
									<input type="email" class="form-control" id="inputEmail" placeholder="Email" data-error="Bruh, that email address is invalid" required>
									<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
								</div>
								<div class="form-group">
									<input type="text" data-toggle="validator" data-minlength="6" class="form-control" id="inputPassword" placeholder="Enter your phone number" required>
								</div>
								<div class="bottom">
									<div class="form-group">
										<button type="submit" class="btn btn-primary disabled">Login</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
</div>
<?php
require_once __DIR__ . '/layout/footer.php';
?>