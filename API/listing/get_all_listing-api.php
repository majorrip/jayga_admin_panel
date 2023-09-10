<?php

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

// Function to retrieve all listings with their images
function getAllListings() {
    try {
        global $conn;
        
        $stmt = $conn->prepare('SELECT * FROM listing');
        $stmt->execute();
        $listings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($listings as &$listing) {
            $listingId = $listing['listing_id'];
            $stmt = $conn->prepare('SELECT * FROM listing_images WHERE listing_id = :listing_id');
            $stmt->bindParam(':listing_id', $listingId);
            $stmt->execute();
            $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $listing['images'] = $images;
        }

        // Output the listings information in JSON format
        header('Content-Type: application/json');
        echo json_encode(array(
            'listings' => $listings
        ));

    } catch (PDOException $e) {
        // Handle database connection error or query error
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(array('error' => 'Internal Server Error'));
        die();
    }
}

// Handle RESTful API routing
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    getAllListings();
} else {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(array('error' => 'Not Found'));
}

?>