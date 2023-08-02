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

// fetch_nid_pictures.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];

        // Prepare and execute the SQL query to fetch NID picture paths for the selected user_id
        $sql = "SELECT user_nid_targetlocation FROM user_nid WHERE user_id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch the NID picture paths and store them in an array
        $nid_picture_paths = array();
        while ($row = $result->fetch_assoc()) {
            $nid_picture_paths[] = $row['user_nid_targetlocation'];
        }

        // Close the prepared statement
        $stmt->close();

        // Send the NID picture paths as a JSON response
        header('Content-Type: application/json');
        echo json_encode($nid_picture_paths);
    } else {
        error_reporting(E_ALL);
ini_set('display_errors', 1);
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
