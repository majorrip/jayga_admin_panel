<?php

//Including Database Connection From db.php file to avoid rewriting in all files
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
	<title>Jayga Admin - Edit Listing</title>
	<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="assets/css/feathericon.min.css">
	<link rel="stylesheet" href="assets/plugins/morris/morris.css">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

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
							<h3 class="page-title mt-5">Edit Listing</h3> </div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
					<form id="listingForm" action="crud/update-listing.php" method="post" enctype="multipart/form-data">
							<div class="row formtype">

							<div class="col-md-4">
								<div class="form-group">
								<label>Listing_ID - Listing_Name - Lister_ID</label>
								<select class="form-control" id="listing_id" name="listing_id" required>
											<option selected="" value="">Select Listing ID and Name</option>
											<?php
											// Assuming a database connection is established and stored in the variable $conn

											// Fetch listings from the database
											$sql = "SELECT * FROM listing";
											$result = $conn->query($sql);

											if ($result->num_rows > 0) {
												while ($row = $result->fetch_assoc()) {
													$optionValue = $row['listing_id'];
													$optionName = $row['lister_name'];
													$guestNum = $row['guest_num'];
													$bedNum = $row['bed_num'];
													$bathroomNum = $row['bathroom_num'];
													$listingTitle = $row['listing_title'];
													$listingDescription = $row['listing_description'];
													$price = $row['full_day_price_set_by_user'];
													$listingAddress = $row['listing_address'];
													$zipCode = $row['zip_code'];
													$district = $row['district'];
													$town = $row['town'];
													$allowShortStay = $row['allow_short_stay'];
													$isPeaceful = $row['describe_peaceful'];
													$isUnique = $row['describe_unique'];
													$isFamilyFriendly = $row['describe_familyfriendly'];
													$isStylish = $row['describe_stylish'];
													$isCentral = $row['describe_central'];
													$isSpacious = $row['describe_spacious'];
													$hasPrivateBathroom = $row['bathroom_private'];
													$isBreakfastAvailable = $row['breakfast_availability'];
													$hasRoomLock = $row['room_lock'];
													$hasAnyoneElse = $row['who_else_might_be_there'];
													$listingType = $row['listing_type'];

													// Generate the <option> element with the relevant data attributes
													echo "<option value='$optionValue' data-name='$optionName' data-lister-id='$optionValue' data-guest-num='$guestNum' data-bedroom-num='$bedNum' data-bathroom-num='$bathroomNum' data-listing-title='$listingTitle' data-describe-listing='$listingDescription' data-price='$price' data-listing-address='$listingAddress' data-zip-code='$zipCode' data-district='$district' data-town='$town' data-allow-short-stay='$allowShortStay' data-is-peaceful='$isPeaceful' data-is-unique='$isUnique' data-is-family-friendly='$isFamilyFriendly' data-is-stylish='$isStylish' data-is-central='$isCentral' data-is-spacious='$isSpacious' data-private-bathroom='$hasPrivateBathroom' data-breakfast-available='$isBreakfastAvailable' data-room-lock='$hasRoomLock' data-anyone-else='$hasAnyoneElse' data-listing-type='$listingType'>$optionValue - $optionName</option>";
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
										<br><input type="checkbox" name="allow_short_stay" value="1" <?php echo $allowShortStay === "1" ? "checked" : ""; ?>>
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Is it peaceful?</label>
										<br><input type="checkbox" name="is_it_peaceful" value="1" <?php echo $isPeaceful === "1" ? "checked" : ""; ?>>
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Is it unique?</label>
										<br><input type="checkbox" name="is_it_unique" value="1" <?php echo $isUnique === "1" ? "checked" : ""; ?>>
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Is it family friendly?</label>
										<br><input type="checkbox" name="is_it_family_friendly" value="1" <?php echo $isFamilyFriendly === "1" ? "checked" : ""; ?>>
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Is it stylish?</label>
										<br><input type="checkbox" name="is_it_stylish" value="1" <?php echo $isStylish === "1" ? "checked" : ""; ?>>
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Is it central?</label>
										<br><input type="checkbox" name="is_it_central" value="1" <?php echo $isCentral === "1" ? "checked" : ""; ?>>
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Is it spacious?</label>
										<br><input type="checkbox" name="is_it_spacious" value="1" <?php echo $isSpacious === "1" ? "checked" : ""; ?>>
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Does it have a private bathroom?</label>
										<br><input type="checkbox" name="private_bathroom" value="1" <?php echo $hasPrivateBathroom === "1" ? "checked" : ""; ?>>
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Is breakfast available?</label>
										<br><input type="checkbox" name="breakfast_available" value="1" <?php echo $isBreakfastAvailable === "1" ? "checked" : ""; ?>>
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Is room lock available?</label>
										<br><input type="checkbox" name="room_lock" value="1" <?php echo $hasRoomLock === "1" ? "checked" : ""; ?>> 
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Will there be anyone else in the house?</label>
										<br><input type="checkbox" name="anyone_else" value="1" <?php echo $hasAnyoneElse === "1" ? "checked" : ""; ?>>
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
                                                <!-- Buttons to show NID pictures -->
                                    <div class="form-group">
                                            <label>Show Listing Pictures</label><br>
                                            <button type="button" class="btn btn-secondary" id="show_listing_pic">Show</button>
                                    </div>
                                </div>

								<!-- Add this div to display the carousel -->
								<div id="listing_pictures"></div>

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
							<button type="post" class="btn btn-primary buttonedit1">Update Listing</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/plugins/raphael/raphael.min.js"></script>
	<script src="assets/js/moment.min.js"></script>
	<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
	<script src="assets/js/script.js"></script>
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

	<!-- <script>
	$(function() {
		$('#datetimepicker3').datetimepicker({
			format: 'LT'
		});
	});
	</script> -->

<script>
    // Function to handle the change event of the listing ID dropdown
    function handleListingSelection() {
        console.log("Function called!");

        // Get the selected option element
        const selectedOption = document.getElementById('listing_id').options[document.getElementById('listing_id').selectedIndex];

        // Get the listing ID and name from the data attributes of the selected option
        const selectedListingId = selectedOption.value;
        const selectedListerName = selectedOption.getAttribute('data-name');

        console.log("Selected Listing ID:", selectedListingId);
        console.log("Selected Lister Name:", selectedListerName);

        // Fill the hidden input fields with the selected listing ID and lister name
        document.getElementById('selected_lister_id').value = selectedListingId;
        document.getElementById('selected_lister_name').value = selectedListerName;

        // Fill other input fields with the selected listing's information
        document.querySelector('input[name="guest_num"]').value = selectedOption.getAttribute('data-guest-num');
        document.querySelector('input[name="bedroom_num"]').value = selectedOption.getAttribute('data-bedroom-num');
        document.querySelector('input[name="bathroom_num"]').value = selectedOption.getAttribute('data-bathroom-num');
        document.querySelector('input[name="listing_title"]').value = selectedOption.getAttribute('data-listing-title');
        document.querySelector('textarea[name="describe_listing"]').value = selectedOption.getAttribute('data-describe-listing');
        document.querySelector('input[name="price"]').value = selectedOption.getAttribute('data-price');
        document.querySelector('input[name="listing_address"]').value = selectedOption.getAttribute('data-listing-address');
        document.querySelector('input[name="zip_code"]').value = selectedOption.getAttribute('data-zip-code');
        document.querySelector('input[name="district"]').value = selectedOption.getAttribute('data-district');
        document.querySelector('input[name="town"]').value = selectedOption.getAttribute('data-town');

        // Set the toggle state based on the boolean values (if available)
        const allowShortStay = selectedOption.getAttribute('data-allow-short-stay');
        const isPeaceful = selectedOption.getAttribute('data-is-peaceful');
        const isUnique = selectedOption.getAttribute('data-is-unique');
        const isFamilyFriendly = selectedOption.getAttribute('data-is-family-friendly');
        const isStylish = selectedOption.getAttribute('data-is-stylish');
        const isCentral = selectedOption.getAttribute('data-is-central');
        const isSpacious = selectedOption.getAttribute('data-is-spacious');
        const hasPrivateBathroom = selectedOption.getAttribute('data-private-bathroom');
        const isBreakfastAvailable = selectedOption.getAttribute('data-breakfast-available');
        const hasRoomLock = selectedOption.getAttribute('data-room-lock');
        const hasAnyoneElse = selectedOption.getAttribute('data-anyone-else');

        document.querySelector('input[name="allow_short_stay"]').checked = allowShortStay === "1";
        document.querySelector('input[name="is_it_peaceful"]').checked = isPeaceful === "1";
        document.querySelector('input[name="is_it_unique"]').checked = isUnique === "1";
        document.querySelector('input[name="is_it_family_friendly"]').checked = isFamilyFriendly === "1";
        document.querySelector('input[name="is_it_stylish"]').checked = isStylish === "1";
        document.querySelector('input[name="is_it_central"]').checked = isCentral === "1";
        document.querySelector('input[name="is_it_spacious"]').checked = isSpacious === "1";
        document.querySelector('input[name="private_bathroom"]').checked = hasPrivateBathroom === "1";
        document.querySelector('input[name="breakfast_available"]').checked = isBreakfastAvailable === "1";
        document.querySelector('input[name="room_lock"]').checked = hasRoomLock === "1";
        document.querySelector('input[name="anyone_else"]').checked = hasAnyoneElse === "1";

        // Set the selected option in the listing type dropdown
        const listingType = selectedOption.getAttribute('data-listing-type');
        document.querySelector('select[name="listing_type"]').value = listingType;
    }

    // Attach the event listener to the listing ID dropdown
    document.getElementById('listing_id').addEventListener('change', handleListingSelection);

    // Trigger the event on page load to fill the input fields if a listing is already selected
    handleListingSelection();
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
        // Event listener for the "show_listing" button
        $("#show_listing_pic").click(function() {
            // Get the selected listing_id from the dropdown
            var selectedlistingId = $("#listing_id").val();
            console.log("Selected Listing ID:", selectedlistingId);
            if (selectedlistingId !== "") {
                // Make an AJAX request to fetch the picture paths from the server
                $.ajax({
                    type: "POST",
                    url: "crud/get_listing_images.php",
                    data: { listing_id: selectedlistingId },
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
                            alert("No images found for Listing ID " + selectedlistingId);
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