<?php

//Including Database Connection From db.php file to avoid rewriting in all files
require_once("database/connection/db.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>Jayga Admin - Create Listing</title>
	<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="assets/css/feathericon.min.css">
	<link rel="stylesheet" href="assets/plugins/morris/morris.css">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
 </head>

<body>
	<div class="main-wrapper">
		<div class="header">
			<div class="header-left">
				<a href="index.php" class="logo"> <img src="assets/img/hotel_logo.png" width="50" height="70" alt="logo"> <span class="logoclass">Jayga Admin Panel</span> </a>
				<a href="index.php" class="logo logo-small"> <img src="assets/img/hotel_logo.png" alt="Logo" width="30" height="30"> </a>
			</div>
			<a href="javascript:void(0);" id="toggle_btn"> <i class="fe fe-text-align-left"></i> </a>
			<a class="mobile_btn" id="mobile_btn"> <i class="fas fa-bars"></i> </a>
			<ul class="nav user-menu">
				<li class="nav-item dropdown noti-dropdown">
					<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"> <i class="fe fe-bell"></i> <span class="badge badge-pill">3</span> </a>
					<!-- <div class="dropdown-menu notifications">
						<div class="topnav-dropdown-header"> <span class="notification-title">Notifications</span> <a href="javascript:void(0)" class="clear-noti"> Clear All </a> </div>
						<div class="noti-content">
							<ul class="notification-list">
								<li class="notification-message">
									<a href="#">
										<div class="media"> <span class="avatar avatar-sm">
											<img class="avatar-img rounded-circle" alt="User Image" src="assets/img/profiles/avatar-02.jpg">
											</span>
											<div class="media-body">
												<p class="noti-details"><span class="noti-title">Carlson Tech</span> has approved <span class="noti-title">your estimate</span></p>
												<p class="noti-time"><span class="notification-time">4 mins ago</span> </p>
											</div>
										</div>
									</a>
								</li>
								<li class="notification-message">
									<a href="#">
										<div class="media"> <span class="avatar avatar-sm">
											<img class="avatar-img rounded-circle" alt="User Image" src="assets/img/profiles/avatar-11.jpg">
											</span>
											<div class="media-body">
												<p class="noti-details"><span class="noti-title">International Software
													Inc</span> has sent you a invoice in the amount of <span class="noti-title">$218</span></p>
												<p class="noti-time"><span class="notification-time">6 mins ago</span> </p>
											</div>
										</div>
									</a>
								</li>
								<li class="notification-message">
									<a href="#">
										<div class="media"> <span class="avatar avatar-sm">
											<img class="avatar-img rounded-circle" alt="User Image" src="assets/img/profiles/avatar-17.jpg">
											</span>
											<div class="media-body">
												<p class="noti-details"><span class="noti-title">John Hendry</span> sent a cancellation request <span class="noti-title">Apple iPhone
													XR</span></p>
												<p class="noti-time"><span class="notification-time">8 mins ago</span> </p>
											</div>
										</div>
									</a>
								</li>
								<li class="notification-message">
									<a href="#">
										<div class="media"> <span class="avatar avatar-sm">
											<img class="avatar-img rounded-circle" alt="User Image" src="assets/img/profiles/avatar-13.jpg">
											</span>
											<div class="media-body">
												<p class="noti-details"><span class="noti-title">Mercury Software
													Inc</span> added a new product <span class="noti-title">Apple
													MacBook Pro</span></p>
												<p class="noti-time"><span class="notification-time">12 mins ago</span> </p>
											</div>
										</div>
									</a>
								</li>
							</ul>
						</div>
						<div class="topnav-dropdown-footer"> <a href="#">View all Notifications</a> </div>
					</div> -->
				</li>
				<li class="nav-item dropdown has-arrow">
					<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"> <span class="user-img"><img class="rounded-circle" src="assets/img/profiles/avatar-01.jpg" width="31" alt=""></span> </a>
					<div class="dropdown-menu">
						<div class="user-header">
							<div class="avatar avatar-sm"> <img src="assets/img/profiles/avatar-01.jpg" alt="User Image" class="avatar-img rounded-circle"> </div>
							<div class="user-text">
								<h6>Jayga Admin</h6>
								<p class="text-muted mb-0">Administrator</p>
							</div>
						</div> <a class="dropdown-item" href="profile.php">My Profile</a> <a class="dropdown-item" href="settings.php">Account Settings</a> <a class="dropdown-item" href="crud/logout.php">Logout</a> </div>
				</li>
			</ul>
		</div>
	<?php require("header.php"); ?>
	
		<div class="page-wrapper">
			<div class="content container-fluid">
				<div class="page-header">
					<div class="row align-items-center">
						<div class="col">
							<h3 class="page-title mt-5">Add Lister</h3> </div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
					<form action="crud/create-listing.php" method="post" enctype="multipart/form-data">
							<div class="row formtype">

							<div class="col-md-4">
								<div class="form-group">
									<label>Lister ID and Name</label>
									<select class="form-control" id="lister_id" name="lister_id" required>
										<option selected="" value="">Select Lister ID and Name</option>
										<?php
										// Assuming a database connection is established and stored in the variable $conn
										$sql = "SELECT * FROM lister_user";
										$result = $conn->query($sql);

										if ($result->num_rows > 0) {
											while ($row = $result->fetch_assoc()) {
												echo "<option value='" . $row['lister_id'] . "' data-name='" . $row['lister_name'] . "'>" . $row['lister_id'] . " - " . $row['lister_name'] . "</option>";
											}
										}
										?>
									</select>
								</div>
							</div>

							<!-- Hidden input fields to store the selected lister_id and lister_name -->
							<input type="hidden" id="selected_lister_id" name="selected_lister_id" value="">
							<input type="hidden" id="selected_lister_name" name="selected_lister_name" value="">




								<div class="col-md-4">
									<div class="form-group">
										<label>Guest Number Allowed</label>
										<input class="form-control" name="guest_num" type="number" > </div>
								</div>

								
								<div class="col-md-4">
									<div class="form-group">
										<label>How many Bedrooms?</label>
										<input class="form-control" name="bedroom_num" type="number" > </div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>How many Bathrooms?</label>
										<input class="form-control" name="bathroom_num" type="number" > </div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Give your Listing a title</label>
										<input class="form-control" name="listing_title" type="text" > </div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Describe Listing?</label>
										<!-- <input class="form-control" name="name" type="text" >  -->
										<textarea class="form-control" rows="5" name="describe_listing"></textarea>
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>What is the price set for a day stay?</label>
										<input class="form-control" name="price" type="number" > </div>
								</div>

								<!-- <div class="col-md-4">
									<div class="form-group">
										<label>What is the price for short stay?</label>
										<input class="form-control" name="name" type="text" > </div>
								</div> -->

								<div class="col-md-4">
									<div class="form-group">
										<label>What is the listing adress?</label>
										<input class="form-control" name="listing_address" type="text" > </div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Listing zip code?</label>
										<input class="form-control" name="zip_code" type="text" > </div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Which district is it in?</label>
										<input class="form-control" name="district" type="text" > </div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Which town is it in?</label>
										<input class="form-control" name="town" type="text" > </div>
								</div>
								


								<div class="col-md-4">
									<div class="form-group">
										<label>Would you allow short stay?</label>
										<br><input type="checkbox" name="allow_short_stay" value= 1 checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger">
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Is it peaceful?</label>
										<br><input type="checkbox" name="is_it_peaceful" value= 1 checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger">
									 </div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Is it unique?</label>
										<br><input type="checkbox" name="is_it_unique" value= 1 checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger">
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Is it family friendly?</label>
										<br><input type="checkbox" name="is_it_family_friendly" value= 1 checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger"></div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Is it stylish?</label>
										<br><input type="checkbox" name="is_it_stylish" value= 1 checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger">
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Is it central?</label>
										<br><input type="checkbox" name="is_it_central" value= 1 checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger">
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Is it spacious?</label>
										<br><input type="checkbox" name="is_it_spacious" value= 1 checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger">
									 </div>
								</div>

								

								<div class="col-md-4">
									<div class="form-group">
										<label>Does it have a private bathroom?</label>
										<br><input type="checkbox" name="private_bathroom" value= 1 checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger">
									 </div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Is breakfast available?</label>
										<br><input type="checkbox" name="breakfast_available" value= 1 checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger">
									 </div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Is room lock available?</label>
										<br><input type="checkbox" name="room_lock" value= 1 checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger"> 
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Will there be anyone else in the house?</label>
										<br><input type="checkbox" name="anyone_else" value= 1 checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger">
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Listing Type</label>
										<select class="form-control" name="listing_type">
											<option>Select</option>
											<option>Room</option>
											<option>Appartment</option>
											<option>Hotel</option>
											<!-- <option>King</option>
											<option>Suite</option>
											<option>Villa</option> -->
										</select>
										
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label> Upload Listing Pictures</label>
										<div class="custom-file mb-3">
										<!-- <input type="file" class="custom-file-input" name="user_pic[]" multiple onchange="displayFileNames(event)">
  												<div id="file-names"></div> -->
											<input type="file" name="listing_pictures[]" class="form-control input-lg" multiple >
											<!-- <label class="custom-file-label" for="customFile">Choose file</label> -->
										</div>
									</div>
								</div>

							</div>
							<button type="post" class="btn btn-primary buttonedit1">Create Listing</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="assets/js/jquery-3.5.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/plugins/raphael/raphael.min.js"></script>
	<script src="assets/js/moment.min.js"></script>
	<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
	<script src="assets/js/script.js"></script>
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
	<script>
	document.getElementById("lister_id").addEventListener("change", function() {
		var selectElement = this;
		var selectedOption = selectElement.options[selectElement.selectedIndex];
		var selectedListerID = selectedOption.value;
		var selectedListerName = selectedOption.getAttribute("data-name");

		// Update the hidden input fields with the selected lister_id and lister_name
		document.getElementById("selected_lister_id").value = selectedListerID;
		document.getElementById("selected_lister_name").value = selectedListerName;

		// You can also display the selected lister name somewhere if needed
		// For example, in a <span> element with id="selected_lister_name_display"
		// document.getElementById("selected_lister_name_display").textContent = selectedListerName;
	});
	</script>


	<script>
	$(function() {
		$('#datetimepicker3').datetimepicker({
			format: 'LT'
		});
	});
	</script>
</body>

</html>