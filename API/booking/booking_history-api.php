<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle database connection
$host = 'podma-bd-cp1';
$username = 'jaygabdc_atif_admin';
$password = 'jaygabd_atif_123';
$dbname = 'jaygabdc_jayga_db_1';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle database connection error
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(array('error' => 'Internal Server Error'));
    die();
}

// Function to retrieve booking information for a specific user
function getUserBookings() {
    // Check if the required parameters are provided
    if (!isset($_POST['user_id'])) {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(array('error' => 'Missing required fields'));
        die();
    }

    // Retrieve user_id from the request body
    $user_id = intval($_POST['user_id']);

    try {
        global $conn;

        // Retrieve booking information for the specific user
        $stmt = $conn->prepare('SELECT * FROM booking WHERE user_id = :user_id');
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Collect listing and image information for each booking
        foreach ($bookings as &$booking) {
            $listing_id = $booking['listing_id'];

            // Retrieve listing information
            $stmt = $conn->prepare('SELECT * FROM listing WHERE listing_id = :listing_id');
            $stmt->bindParam(':listing_id', $listing_id, PDO::PARAM_INT);
            $stmt->execute();
            $listing = $stmt->fetch(PDO::FETCH_ASSOC);

            // Retrieve image paths for the listing
            $stmt = $conn->prepare('SELECT listing_filename FROM listing_images WHERE listing_id = :listing_id');
            $stmt->bindParam(':listing_id', $listing_id, PDO::PARAM_INT);
            $stmt->execute();
            $images = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Add listing and image information to the booking data
            $booking['listing'] = $listing;
            $booking['images'] = $images;
        }

        // Output the bookings information in JSON format
        header('Content-Type: application/json');
        echo json_encode(array('bookings' => $bookings));

    } catch (PDOException $e) {
        // Handle database connection error or query error
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(array('error' => 'Internal Server Error'));
        die();
    }
}

// Handle RESTful API routing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    getUserBookings();
} else {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(array('error' => 'Not Found'));
}
?>
