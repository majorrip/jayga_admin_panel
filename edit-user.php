<?php

// require_once("..database/connection/db.php");
session_start();

if(empty($_SESSION['admin_id'])) {
  header("Location:index.php");
  exit();
}

//Including Database Connection From db.php file to avoid rewriting in all files
require_once("database/connection/db.php");


?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>Jayga - Add User</title>
	<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="assets/css/feathericon.min.css">
	<link rel="stylesheet" href="assets/plugins/morris/morris.css">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap-datetimepicker.min.css">
	<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/style.css"> 

    <style>
/* Style the carousel images to fit inside the modal */
.carousel {
  display: flex;
  align-items: center;
  justify-content: center;
}

.carousel img {
  max-width: 100%;
  max-height: 400px; /* Set a maximum height for the images */
  width: auto;
  height: auto;
  margin: 0 auto; /* Center the images horizontally */
}

/* Style the modal to be responsive */
.modal {
  display: none;
  position: fixed;
  z-index: 9999;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.8);
  overflow: auto;
}

/* Style the modal content */
.modal-content {
  max-width: 90%;
  max-height: 90%;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: #fff;
  padding: 15px;
}

/* Style the close button */
.close {
  color: white;
  position: absolute;
  top: 10px;
  right: 25px;
  font-size: 35px;
  font-weight: bold;
  cursor: pointer;
}

/* Style the previous and next buttons in the carousel */
.slick-prev,
.slick-next {
  z-index: 1;
}

/* Adjust the carousel dots for better visibility */
.slick-dots li button:before {
  font-size: 12px;
  color: #fff;
  opacity: 0.7;
}

/* Style the carousel dots active state */
.slick-dots li.slick-active button:before {
  opacity: 1;
}
</style>



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
							<h3 class="page-title mt-5">Edit User</h3> </div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
					    <form action="crud/update-user.php" method="post" enctype="multipart/form-data">
								
                                        <div class="row formtype">
                                                <!-- Add a hidden input field to store the user ID -->
                                                <input type="hidden" name="user_id" id="userIdInput" value="">

                                                <div class="col-md-4">
                                            <div class="form-group">
                                                <label>User ID and Name</label>
                                                    <select class="form-control" id="user_id" name="user_id" required>
                                                        <option selected="" value="">Select User ID and Name</option>
                                                                <?php
                                                                // Assuming a database connection is established and stored in the variable $conn
                                                                $sql = "SELECT * FROM users";
                                                                $result = $conn->query($sql);

                                                                if ($result->num_rows > 0) {
                                                                    while ($row = $result->fetch_assoc()) {
                                                                        // Set the is_lister value as the value attribute for each option
                                                                        $isListerValue = $row['is_lister'] ? '1' : '0';
                                                                        echo "<option value='" . $row['user_id'] . "' data-name='" . $row['user_name'] . "' data-email='" . $row['user_email'] . "' data-phone='" . $row['user_phone_num'] . "' data-nid='" . $row['user_nid'] . "' data-birthdate='" . $row['user_dob'] . "' data-address='" . $row['user_address'] . "' data-is-lister='" . $isListerValue . "'>" . $row['user_id'] . " - " . $row['user_name'] . "</option>";
                                                                    }
                                                                }
                                                                ?>
                                                        </select>



                                            </div>
                                        </div>
                                        <!-- Hidden input fields to store the selected user_id and lister_name -->
                                        <input type="hidden" id="selected_user_id" name="selected_user_id" value="">
                                        <input type="hidden" id="selected_user_name" name="selected_user_name" value="">
                                        <input type="hidden" name="userid" id="userIdInput" value="">

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>User Email</label>
                                                        <input class="form-control" name="name" type="text" >
                                                    </div>
                                                </div>

                                                

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>User Email</label>
                                                        <input class="form-control" name="email" type="text" >
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Phone number</label>
                                                        <input class="form-control" name="phone" type="text" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>User NID</label>
                                                        <input class="form-control" name="nid" type="text" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Birth Date</label>
                                                        <div class="cal-icon">
                                                            <input type="Date" name="birthdate" class="form-control" value=""> </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>User Address</label>
                                                        <input class="form-control" name="address" type="text" value="">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <!-- Buttons to be added -->
                                                    <div class="form-group">
                                                        <label>Show profile picture</label><br>
                                                        <button type="button" class="btn btn-secondary" id="show_profile_pic">Show</button>
                                                    </div>
                                                </div>

                                                <!-- Add this div to display the carousel -->
                                                <div id="profile_pictures"></div>



                                                <div class="col-md-4">
                                                <!-- Buttons to show NID pictures -->
                                                    <div class="form-group">
                                                        <label>Show NID Pictures</label><br>
                                                        <button type="button" class="btn btn-secondary" id="show_nid_pic">Show</button>
                                                    </div>
                                                </div>
                                                
                                                

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Update User Picture</label>
                                                        <div class="custom-file mb-3">
                                                            <input type="file" name="user_pic[]" class="form-control input-lg" multiple>
                                                        </div>
                                                    </div>
                                                <!-- Show User Pictures -->
                                                </div>


                                            <!-- <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Update User NID</label>
                                                    <div class="custom-file mb-3">
                                                        <input type="file" name="user_nid[]" class="form-control input-lg" multiple>
                                                    </div>
                                                </div> -->
                                                <!-- Show User NID Images -->
                                                
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="custom-file mb-3">
                                                        <br>
                                                        <label>
                                                            <input type="checkbox" name="is_lister" id="is_lister_toggle">
                                                            Are you a Host?
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>



                                            </div>
                                    <button type="submit" class="btn btn-primary buttonedit1">Update User</button>
                                </div>
					        </form>
                        </div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/plugins/raphael/raphael.min.js"></script>
	<script src="assets/js/moment.min.js"></script>
	<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
	<script src="assets/js/script.js"></script>
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
    // Get the checkbox element
    const isListerCheckbox = document.getElementById('is_lister_toggle');

    // Add an event listener to the checkbox
    isListerCheckbox.addEventListener('change', function () {
        // Set the value of the checkbox to 1 if checked, otherwise set it to 0
        this.value = this.checked ? 1 : 0;
    });
</script>


	<script>
	$(function() {
		$('#datetimepicker3').datetimepicker({
			format: 'LT'
		});
	});
	</script>

<!-- Add this script inside the HTML body or in a separate JavaScript file -->
<script>
    // Function to handle the change event of the dropdown
    function handleUserSelection() {
        // Get the selected option element
        const selectedOption = document.getElementById('user_id').options[document.getElementById('user_id').selectedIndex];

        // Get the user ID and name from the data attributes of the selected option
        const selectedUserId = selectedOption.value;
        const selectedUserName = selectedOption.getAttribute('data-name');

        // Fill the hidden input fields with the selected user ID and name
        document.getElementById('selected_user_id').value = selectedUserId;
        document.getElementById('selected_user_name').value = selectedUserName;

        // Fill other input fields with the selected user's information
        document.querySelector('input[name="name"]').value = selectedOption.getAttribute('data-name');
        document.querySelector('input[name="email"]').value = selectedOption.getAttribute('data-email');
        document.querySelector('input[name="phone"]').value = selectedOption.getAttribute('data-phone');
        document.querySelector('input[name="nid"]').value = selectedOption.getAttribute('data-nid');
        document.querySelector('input[name="birthdate"]').value = selectedOption.getAttribute('data-birthdate');
        document.querySelector('input[name="address"]').value = selectedOption.getAttribute('data-address');

        // Set the toggle state based on the is_lister value (if available)
        const isListerValue = selectedOption.getAttribute('data-is-lister');
        const isListerToggle = document.getElementById('is_lister_toggle');
        // Clear the previously selected value first
        isListerToggle.checked = false;
        if (isListerValue !== null) {
            // Set the toggle based on the value directly (either "0" or "1")
            isListerToggle.checked = isListerValue === "1";
        }
    }

    // Attach the event listener to the dropdown
    document.getElementById('user_id').addEventListener('change', handleUserSelection);

    // Trigger the event on page load to fill the input fields if a user is already selected
    handleUserSelection();
</script>

<script>
    // Delegate the click event on the close button to the document
    $(document).on('click', '.close', function() {
        $(".modal").fadeOut(function() {
            $(this).remove();
        });
    });
</script>


<script>
    $(document).ready(function() {
        // Event listener for the "show_profile_pic" button
        $("#show_profile_pic").click(function() {
            // Get the selected user_id from the dropdown
            var selectedUserId = $("#user_id").val();
            console.log("Selected User ID:", selectedUserId);
            if (selectedUserId !== "") {
                // Make an AJAX request to fetch the picture paths from the server
                $.ajax({
                    type: "POST",
                    url: "crud/get-user-pictures.php",
                    data: { user_id: selectedUserId },
                    dataType: "json",
                    success: function(response) {
                // Check if images were found for the listing_id
                if (response.length > 0) {
                    // Generate the HTML for the images in the carousel
                    var carouselItems = "";
                    for (var i = 0; i < response.length; i++) {
                        // Assuming images are located in the "uploads" directory
                        var imageUrl = "uploads/" + response[i];
                        carouselItems += '<div><img src="' + imageUrl + '" alt="Listing Image"></div>';
                    }

                    // Display the carousel in the modal pop-up
                    var modalContent = '<div class="modal-content"><div class="carousel">' + carouselItems + '</div></div>';
                    var modal = '<div class="modal">' + modalContent + '<span class="close">&times;</span></div>';
                    $(modal).appendTo("body");

                    // Show the modal pop-up
                    $(".modal").fadeIn();

                    // Initialize the Slick carousel
                    $(".carousel").slick({
                        arrows: true,
                        dots: true,
                        infinite: true,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    });

                    // Close the modal when the close button is clicked
                    $(".close").click(function() {
                        $(".modal").fadeOut(function() {
                            $(this).remove();
                        });
                    });
                } else {
                    // If no images found, display a message
                    alert("No images found for Listing ID " + listingId);
                }
            },
                    error: function(xhr, status, error) {
    // Log the XMLHttpRequest object (xhr), the status, and the error message
    console.log("XMLHttpRequest:", xhr);
    console.log("Status:", status);
    console.log("Error:", error);
}
                });
            }
        });
    });
</script>


<script>
    $(document).ready(function() {
    // Event listener for the "Show NID Pictures" button
    $("#show_nid_pic").click(function() {
        // Get the selected user_id from the dropdown
        var selectedUserId = $("#user_id").val();
        console.log("Selected User ID:", selectedUserId);
        if (selectedUserId !== "") {
            // Make an AJAX request to fetch the NID picture paths from the server
            $.ajax({
                type: "POST",
                url: "crud/get-nid-pictures.php", // Correct the PHP script file name
                data: { user_id: selectedUserId },
                dataType: "json",
                success: function(response) {
                    // Check if images were found for the user_id
                    console.log("Response from server:", response);
                    if (response.length > 0) {
                        // Generate the HTML for the images in the carousel
                        var carouselItems = "";
                        for (var i = 0; i < response.length; i++) {
                            // Assuming images are located in the "uploads" directory
                            var imageUrl = "uploads/" + response[i];
                            carouselItems += '<div><img src="' + imageUrl + '" alt="NID Image"></div>';
                        }

                        // Display the carousel in the modal pop-up
                        var modalContent = '<div class="modal-content"><div class="carousel">' + carouselItems + '</div></div>';
                        var modal = '<div class="modal">' + modalContent + '<span class="close">&times;</span></div>';
                        $(modal).appendTo("body");

                        // Show the modal pop-up
                        $(".modal").fadeIn();

                        // Initialize the Slick carousel
                        $(".carousel").slick({
                            arrows: true,
                            dots: true,
                            infinite: true,
                            slidesToShow: 1,
                            slidesToScroll: 1
                        });

                        // Close the modal when the close button is clicked
                        $(".close").click(function() {
                            $(".modal").fadeOut(function() {
                                $(this).remove();
                            });
                        });
                    } else {
                        // If no images found, display a message
                        alert("No NID images found for the selected user.");
                    }
                },
                error: function(xhr, status, error) {
                    // Log the XMLHttpRequest object (xhr), the status, and the error message
                    console.log("XMLHttpRequest:", xhr);
                    console.log("Status:", status);
                    console.log("Error:", error);
                }
            });
        }
    });
});
</script>




</body>

</html>