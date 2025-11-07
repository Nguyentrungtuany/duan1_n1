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
	<div class="main-page compose">
		<h2 class="title1">Compose Mail Page</h2>
		<div class="col-md-4 compose-left">
			<div class="folder widget-shadow">
				<ul>
					<li class="head">Folders</li>
					<li><a href="inbox.html"><i class="fa fa-inbox"></i>Inbox <span>52</span></a></li>
					<li><a href="#"><i class="fa fa fa-envelope-o"></i>Sent </a></li>
					<li><a href="#"><i class="fa fa-file-text-o"></i>Drafts <span>03</span></a> </li>
					<li><a href="#"><i class="fa fa-flag-o"></i>Spam </a></li>
					<li><a href="#"><i class="fa fa-trash-o"></i>Trash</a></li>
				</ul>
			</div>
			<div class="chat-grid widget-shadow">
				<ul>
					<li class="head">Friends (Online) </li>
					<li><a href="#">
							<div class="chat-left">
								<img class="img-circle" src="images/i1.png" alt="">
								<label class="small-badge"></label>
							</div>
							<div class="chat-right">
								<p>Andrew Josifn</p>
								<h6>Nullam quis risus eget </h6>
							</div>
							<div class="clearfix"> </div>
						</a>
					</li>
					<li><a href="#">
							<div class="chat-left">
								<img class="img-circle" src="images/i4.png" alt="">
								<label class="small-badge bg-green"></label>
							</div>
							<div class="chat-right">
								<p>Justen Ferry</p>
								<h6>Urna mollis ornare vel</h6>
							</div>
							<div class="clearfix"> </div>
						</a>
					</li>
					<li><a href="#">
							<div class="chat-left">
								<img class="img-circle" src="images/i3.png" alt="">
								<label class="small-badge bg-green"></label>
							</div>
							<div class="chat-right">
								<p>Brown Andy </p>
								<h6>Quis risus ullam neget </h6>
							</div>
							<div class="clearfix"> </div>
						</a>
					</li>
					<li><a href="#">
							<div class="chat-left">
								<img class="img-circle" src="images/i4.png" alt="">
								<label class="small-badge"></label>
							</div>
							<div class="chat-right">
								<p>Deos Jhon</p>
								<h6>Mollis ornare Urna vel</h6>
							</div>
							<div class="clearfix"> </div>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="col-md-8 compose-right widget-shadow">
			<div class="panel-default">
				<div class="panel-heading">
					Compose New Message
				</div>
				<div class="panel-body">
					<div class="alert alert-info">
						Please fill details to send a new message
					</div>
					<form class="com-mail">
						<input type="text" class="form-control1 control3" placeholder="To :">
						<input type="text" class="form-control1 control3" placeholder="Subject :">
						<textarea rows="6" class="form-control1 control2" placeholder="Message :"></textarea>
						<div class="form-group">
							<div class="btn btn-default btn-file">
								<i class="fa fa-paperclip"></i> Attachment
								<input type="file" name="attachment">
							</div>
							<p class="help-block">Max. 32MB</p>
						</div>
						<input type="submit" value="Send Message">
					</form>
				</div>
			</div>
		</div>
		<div class="clearfix"> </div>
	</div>
</div>
<?php
require_once __DIR__ . '/layout/footer.php';
?>