<?php
// Establish a connection to your MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jayga_db_1";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if the request is a POST request and if it contains the listingId parameter
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["listingId"])) {
  $listingId = $_POST["listingId"];

  // Delete the listing from the "listing" table
  $sql_delete_listing = "DELETE FROM listing WHERE listing_id = $listingId";
  if ($conn->query($sql_delete_listing) === TRUE) {
    // Listing deleted successfully
  } else {
    echo "Error deleting listing: " . $conn->error;
    // You may want to handle errors more gracefully in a production environment
  }

  // Delete the associated listing images from the "listing_images" table
  $sql_delete_images = "DELETE FROM listing_images WHERE listing_id = $listingId";
  if ($conn->query($sql_delete_images) === TRUE) {
    // Images deleted successfully
  } else {
    echo "Error deleting images: " . $conn->error;
    // You may want to handle errors more gracefully in a production environment
  }
}

// Close the database connection
$conn->close();
?>
