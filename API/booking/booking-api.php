<?php

// Enable error reporting for debugging
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
    header('HTTP/1.1 500 Internal Server Error1');
    echo json_encode(array('error' => 'Internal Server Error2'));
    die();
}

// Function to insert booking information
function insertBookingInformation() {
    global $conn; // Declare $conn as a global variable inside the function

    // Check if the required parameters are provided
    if (!isset($_POST['user_id']) || !isset($_POST['lister_id']) || !isset($_POST['listing_id']) || !isset($_POST['date_enter']) || !isset($_POST['date_exit'])) {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(array('error' => 'Missing required fields'));
        die();
    }

    // Retrieve parameters
    $user_id = $_POST['user_id'];
    $lister_id = $_POST['lister_id'];
    $listing_id = $_POST['listing_id'];
    $date_enter = $_POST['date_enter'];
    $date_exit = $_POST['date_exit'];

    // Convert dates from DD-MM-YYYY to YYYY-MM-DD format
    $date_enter = date('Y-m-d', strtotime($date_enter));
    $date_exit = date('Y-m-d', strtotime($date_exit));

    // Calculate days_stayed
    $days_stayed = (strtotime($date_exit) - strtotime($date_enter)) / (60 * 60 * 24);

    try {
        // Check if user_id, lister_id, and listing_id exist in their respective tables
        $userExistsQuery = 'SELECT COUNT(*) FROM users WHERE user_id = :user_id';
        $listerExistsQuery = 'SELECT COUNT(*) FROM lister_user WHERE lister_id = :lister_id';
        $listingExistsQuery = 'SELECT COUNT(*) FROM listing WHERE listing_id = :listing_id';

        $stmt = $conn->prepare($userExistsQuery);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR); // Bind as string
        $stmt->execute();
        $userExists = $stmt->fetchColumn();

        $stmt = $conn->prepare($listerExistsQuery);
        $stmt->bindParam(':lister_id', $lister_id, PDO::PARAM_INT);
        $stmt->execute();
        $listerExists = $stmt->fetchColumn();

        $stmt = $conn->prepare($listingExistsQuery);
        $stmt->bindParam(':listing_id', $listing_id, PDO::PARAM_INT);
        $stmt->execute();
        $listingExists = $stmt->fetchColumn();

        if ($userExists === '0' || $listerExists === '0' || $listingExists === '0') {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(array('error' => 'Invalid user_id, lister_id, or listing_id'));
            die();
        }

        // Retrieve listing information based on listing_id
        $listingQuery = 'SELECT l.listing_id, l.lister_id, lu.lister_name, l.guest_num, l.bed_num, l.bathroom_num, l.listing_title, l.listing_description, l.full_day_price_set_by_user, l.listing_address, l.zip_code, l.town, l.allow_short_stay, l.describe_peaceful, l.describe_unique, l.describe_familyfriendly, l.describe_stylish, l.describe_central, l.describe_spacious, l.bathroom_private, l.breakfast_availability, l.room_lock, l.who_else_might_be_there, l.listing_type FROM listing l INNER JOIN lister_user lu ON l.lister_id = lu.lister_id WHERE l.listing_id = :listing_id';

    

        $stmt = $conn->prepare($listingQuery);
        $stmt->bindParam(':listing_id', $listing_id, PDO::PARAM_INT);
        $stmt->execute();
        $listingInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$listingInfo) {
            header('HTTP/1.1 404 Not Found');
            echo json_encode(array('error' => 'Listing not found'));
            die();
        }

        $listingImagesQuery = 'SELECT listing_img_id, listing_id, lister_id, listing_filename, listing_targetlocation FROM listing_images WHERE listing_id = :listing_id';

        $stmt = $conn->prepare($listingImagesQuery);
        $stmt->bindParam(':listing_id', $listing_id, PDO::PARAM_INT);
        $stmt->execute();
        $listingImages = $stmt->fetchAll(PDO::FETCH_ASSOC);


        // Insert booking information into the database
        $insertQuery = 'INSERT INTO booking (user_id, lister_id, listing_id, days_stayed, date_enter, date_exit) VALUES (:user_id, :lister_id, :listing_id, :days_stayed, :date_enter, :date_exit)';
        $stmt = $conn->prepare($insertQuery);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR); // Bind as string
        $stmt->bindValue(':lister_id', $lister_id, PDO::PARAM_INT);
        $stmt->bindValue(':listing_id', $listing_id, PDO::PARAM_INT);
        $stmt->bindValue(':days_stayed', $days_stayed, PDO::PARAM_INT);
        $stmt->bindValue(':date_enter', $date_enter, PDO::PARAM_STR);
        $stmt->bindValue(':date_exit', $date_exit, PDO::PARAM_STR);

        $stmt->execute();

        $affectedRows = $stmt->rowCount();
        if ($affectedRows > 0) {
            // Create an array with the entered booking information
            $bookingInfo = array(
                'user_id' => $user_id,
                'lister_id' => $lister_id,
                'listing_id' => $listing_id,
                'days_stayed' => $days_stayed,
                'date_enter' => $date_enter,
                'date_exit' => $date_exit
            );

            header('Content-Type: application/json');
            echo json_encode(array(
                'booking_info' => $bookingInfo, // Include entered booking information in the response
                'listing_info' => $listingInfo, // Include listing information in the response
                'listing_images' => $listingImages // Include listing images in the response
            ));
        } else {
            header('HTTP/1.1 500 Internal Server Error3');
            echo json_encode(array('error' => 'Failed to insert booking information'));
        }
    } catch (PDOException $e) {
        // Handle database connection error or query error
        header('HTTP/1.1 500 Internal Server Error4');
        echo json_encode(array('error' => 'Query Execution Error: ' . $e->getMessage()));
        die();
    }
}

// Handle RESTful API routing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    insertBookingInformation();
} else {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(array('error' => 'Not Found'));
}

?>
