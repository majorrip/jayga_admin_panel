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

// Function to recursively delete a directory and its contents
function rmdir_recursive($dir) {
  if (is_dir($dir)) {
      $objects = scandir($dir);
      foreach ($objects as $object) {
          if ($object != "." && $object != "..") {
              if (is_dir($dir . "/" . $object)) {
                  rmdir_recursive($dir . "/" . $object);
              } else {
                  if (!unlink($dir . "/" . $object)) {
                      echo "Error deleting file: " . $dir . "/" . $object . "\n";
                  } else {
                      echo "Deleted file: " . $dir . "/" . $object . "\n";
                  }
              }
          }
      }
      if (!rmdir($dir)) {
          echo "Error deleting directory: " . $dir . "\n";
      } else {
          echo "Deleted directory: " . $dir . "\n";
      }
  }
}

// Check if the request is a POST request and if it contains the listingId parameter
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["listingId"])) {
    $listingId = $_POST["listingId"];

    // Delete the listing from the "listing" table
    $sql_delete_listing = "DELETE FROM listing WHERE listing_id = $listingId";
    if ($conn->query($sql_delete_listing) === TRUE) {
        // Listing deleted successfully

        // Delete the associated listing images from the "listing_images" table
        $sql_delete_images = "DELETE FROM listing_images WHERE listing_id = $listingId";
        if ($conn->query($sql_delete_images) === TRUE) {
            // Images deleted successfully

            

          $folder_path = "../uploads/lister/listings/" . $listingId;
          if (is_dir($folder_path)) {
              rmdir_recursive($folder_path);
}

          

        } else {
            echo "Error deleting images: " . $conn->error;
            // You may want to handle errors more gracefully in a production environment
        }
    } else {
        echo "Error deleting listing: " . $conn->error;
        // You may want to handle errors more gracefully in a production environment
    }
}

$conn->close();

// Redirect back to the page where the deletion was initiated
// header("Location: ../all-listing.php"); // Replace "all-listing.php" with the appropriate page name
// exit();
?>
