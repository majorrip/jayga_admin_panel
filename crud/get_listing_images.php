<?php
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

// fetch_listing_images.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['listing_id'])) {
        $listing_id = $_POST['listing_id'];

        // Prepare and execute the SQL query to fetch picture paths for the selected user_id
        $sql = "SELECT listing_targetlocation FROM listing_images WHERE listing_id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("s", $listing_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch the picture paths and store them in an array
        $picture_paths = array();
        while ($row = $result->fetch_assoc()) {
            $picture_paths[] = $row['listing_targetlocation'];
        }

        // Close the prepared statement
        $stmt->close();

        // Send the picture paths as a JSON response
        header('Content-Type: application/json');
        echo json_encode($picture_paths);
    } else {
        // Handle missing user_id parameter
        header('HTTP/1.1 400 Bad Request');
        echo "Missing user_id parameter.";
    }
    
} else {
    // Handle unsupported request method
    header('HTTP/1.1 405 Method Not Allowed');
    echo "Unsupported request method.";
}
?>