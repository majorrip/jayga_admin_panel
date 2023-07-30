<?php
// Replace these variables with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jayga_db_1";
// Create a connection to the database
$connection = mysqli_connect($servername, $username, $password, $dbname);

// Check if the connection was successful
if (mysqli_connect_errno()) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Query to fetch data from the "listing" table
$query = "SELECT * FROM listing";
$result = mysqli_query($connection, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>Jayga Dashboard</title>
	<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="assets/plugins/datatables/datatables.min.css">
	<link rel="stylesheet" href="assets/css/feathericon.min.css">
	<link rel="stylesheet" href="assets/plugins/morris/morris.css">
	<link rel="stylesheet" href="assets/css/style.css"> 
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">


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
				<a href="index.php" class="logo"> <img src="assets/img/hotel_logo.png" width="50" height="70" alt="logo"> <span class="logoclass">Jayga Admin</span> </a>
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
					<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"> <span class="user-img"><img class="rounded-circle" src="assets/img/profiles/avatar-01.jpg" width="31" alt="Soeng Souy"></span> </a>
					<div class="dropdown-menu">
						<div class="user-header">
							<div class="avatar avatar-sm"> <img src="assets/img/profiles/avatar-01.jpg" alt="User Image" class="avatar-img rounded-circle"> </div>
							<div class="user-text">
								<h6>Jayga Admin</h6>
								<p class="text-muted mb-0">AK 47</p>
							</div>
						</div> <a class="dropdown-item" href="profile.php">My Profile</a> <a class="dropdown-item" href="settings.php">Account Settings</a> <a class="dropdown-item" href="login.php">Logout</a> </div>
				</li>
			</ul>
		</div>
		<?php require("header.php"); ?>
		
		<div class="page-wrapper">
			<div class="content container-fluid">
				<div class="page-header">
					<div class="row align-items-center">
						<div class="col">
							<div class="mt-5">
								<h4 class="card-title float-left mt-2">Listings Read Data</h4>
                                <a href="add-listing.php" class="btn btn-primary float-right veiwbutton ">Add Listing</a>
                            </div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="card card-table">
							<div class="card-body booking_card">
								<div class="table-responsive">
									<table class="datatable table table-stripped table table-hover table-center mb-0">
										<thead>
											<tr>
												<th>Listing ID</th>
												<th>Lister ID</th>
												<th>Lister Name</th>
												<th>Guest Number</th>
												<th>Bed Number</th>
												<th>Bathroom Number</th>
												<th>Listing Title</th>
												<th>Listing Description</th>
												<th>Price</th>
												<th>Listing Address</th>
												<th>Zip Code</th>
												<th>District</th>
												<th>Town</th>
												<th>allow short stays</th>
												<th>Describe Peacefull</th>
												<th>Describe unique</th>
												<th>Describe family friendly</th>
												<th>describe stylish</th>
												<th>Describe central</th>
												<th>Describe spacious</th>
												<th>Bathroom private</th>
												<th>Breakfast availability</th>
												<th>Room Lock</th>
												<th>Who else might be there</th>
												<th>Listing type</th>
												<th class="text-right">Actions</th>
											</tr>
										</thead>
										<tbody>
											<?php
											// Check if there are rows returned from the query
											if ($result->num_rows > 0) {
												// Loop through the rows and print data in the table
												while ($row = $result->fetch_assoc()) {
													echo "<tr>";
													echo "<td>" . $row["listing_id"] . "</td>";
													echo "<td>" . $row["lister_id"] . "</td>";
													echo "<td>" . $row["lister_name"] . "</td>";
													echo "<td>" . $row["guest_num"] . "</td>";
													echo "<td>" . $row["bed_num"] . "</td>";
													echo "<td>" . $row["bathroom_num"] . "</td>";
													echo "<td>" . $row["listing_title"] . "</td>";
													echo "<td>" . $row["listing_description"] . "</td>";
													echo "<td>" . $row["full_day_price_set_by_user"] . "</td>";
													echo "<td>" . $row["listing_address"] . "</td>";
													echo "<td>" . $row["zip_code"] . "</td>";
													echo "<td>" . $row["district"] . "</td>";
													echo "<td>" . $row["town"] . "</td>";
													echo "<td>" . $row["allow_short_stay"] . "</td>";
													echo "<td>" . $row["describe_peaceful"] . "</td>";
													echo "<td>" . $row["describe_unique"] . "</td>";
													echo "<td>" . $row["describe_familyfriendly"] . "</td>";
													echo "<td>" . $row["describe_stylish"] . "</td>";
													echo "<td>" . $row["describe_central"] . "</td>";
													echo "<td>" . $row["describe_spacious"] . "</td>";
													echo "<td>" . $row["bathroom_private"] . "</td>";
													echo "<td>" . $row["breakfast_availability"] . "</td>";
													echo "<td>" . $row["room_lock"] . "</td>";
													echo "<td>" . $row["who_else_might_be_there"] . "</td>";
													echo "<td>" . $row["listing_type"] . "</td>";
													echo '<td class="text-right">
															<button class="btn-show-listing" data-listing-id="' . $row["listing_id"] . '">Show Listing</button>
															<button class="btn btn-danger btn-delete-listing" data-listing-id="' . $row["listing_id"] . '">Delete Listing</button>
															</td>';

													echo "</tr>";
												}
											} else {
												// If no data is found, display a message in a single row
												echo '<tr><td colspan="26">No data found.</td></tr>';
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="delete_asset" class="modal fade delete-modal" role="dialog">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-body text-center"> <img src="assets/img/sent.png" alt="" width="50" height="46">
							<h3 class="delete_class">Are you sure want to delete this Asset?</h3>
							<div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
								<button type="submit" class="btn btn-danger">Delete</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
	<script src="assets/js/jquery-3.5.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="assets/plugins/datatables/datatables.min.js"></script>
	<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/plugins/raphael/raphael.min.js"></script>
	<script src="assets/js/script.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

	<script>
$(document).ready(function() {
    $(".btn-show-listing").click(function() {
        var listingId = $(this).data("listing-id");

		// Close the modal when clicking outside the modal content
		$(document).on("click", function(event) {
        if ($(event.target).closest(".modal-content").length === 0) {
            $(".modal").fadeOut(function() {
                $(this).remove();
            });
        }
    });

    // Prevent the modal from closing when clicking inside the modal content
    $(".modal-content").on("click", function(event) {
        event.stopPropagation();
    });


        // Make an AJAX request to fetch listing images using the listing_id
        $.ajax({
            url: "crud/fetch_listing_images.php",
            type: "GET",
            data: { listing_id: listingId },
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
                // Handle errors, if any
                console.error(error);
            }
        });
    });
});
</script>

<script>
  $(document).ready(function() {
    // Delete Listing Button Click
    $('.btn-delete-listing').on('click', function() {
      var listingId = $(this).data('listing-id');
      // Call a server-side script to delete the listing with the given listingId
      $.ajax({
        url: 'crud/delete_listing.php', // Replace with the actual server-side script URL
        method: 'POST', // Use POST or GET based on your server-side implementation
        data: { listingId: listingId },
        success: function(response) {
          // Handle the response from the server if needed
          console.log('Listing deleted successfully.');

          // Refresh the page after successful deletion
          location.reload(); // This will reload the current page
        },
        error: function(error) {
          // Handle errors if they occur during the deletion process
          console.error('Error deleting listing:', error);
        }
      });
    });
  });
</script>





</body>

</html>