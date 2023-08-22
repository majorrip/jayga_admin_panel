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
    echo json_encode(array('error' => 'Internal Server Error1'));
    die();
}

// Function to add a review
function addReview() {
    // Check if the required parameters are provided
    if (!isset($_POST['user_id']) || !isset($_POST['lister_id']) || !isset($_POST['listing_id']) || !isset($_POST['stars']) || !isset($_POST['review'])) {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(array('error' => 'Missing required fields'));
        die();
    }

    // Retrieve parameters
    $user_id = $_POST['user_id'];
    $lister_id = $_POST['lister_id'];
    $listing_id = $_POST['listing_id'];
    $stars = $_POST['stars'];
    $review = $_POST['review'];

    // Fetch lister name from the listing table based on lister_id and listing_id
    try {
        global $conn;
        $stmt = $conn->prepare('SELECT lister_name FROM listing WHERE lister_id = :lister_id AND listing_id = :listing_id');
        $stmt->bindParam(':lister_id', $lister_id);
        $stmt->bindParam(':listing_id', $listing_id);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($result) {
            $lister_name = $result['lister_name'];
        } else {
            // Handle the case where lister_id and listing_id don't exist in the listing table
            header('HTTP/1.1 404 Not Found');
            echo json_encode(array('error' => 'Lister name not found'));
            die();
        }
    } catch (PDOException $e) {
        // Handle any database error that may occur during the query
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(array('error' => 'Internal Server Error2'));
        die();
    }

    try {
        // Insert the review into the review table
        global $conn;
        $stmt = $conn->prepare('INSERT INTO review (user_id, lister_id, listing_id, lister_name, stars, description) VALUES (:user_id, :lister_id, :listing_id, :lister_name, :stars, :description)');
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':lister_id', $lister_id);
        $stmt->bindParam(':listing_id', $listing_id);
        $stmt->bindParam(':lister_name', $lister_name);
        $stmt->bindParam(':stars', $stars);
        $stmt->bindParam(':description', $review);
        $stmt->execute();

        $affectedRows = $stmt->rowCount();
        if ($affectedRows > 0) {
            // Fetch the inserted data
            $stmt = $conn->prepare('SELECT * FROM review WHERE user_id = :user_id AND lister_id = :lister_id AND listing_id = :listing_id');
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':lister_id', $lister_id);
            $stmt->bindParam(':listing_id', $listing_id);
            $stmt->execute();
            $insertedData = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Output the inserted data in JSON format
            header('Content-Type: application/json');
            echo json_encode(array(
                // 'status' => 'success',
                // 'message' => 'Review added successfully',
                'data' => $insertedData
            ));
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(array('error' => 'Failed to add review'));
        }
    } catch (PDOException $e) {
        // Handle database connection error or query error
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(array('error' => 'Internal Server Error3'));
        die();
    }
}

// Handle RESTful API routing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    addReview();
} else {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(array('error' => 'Not Found'));
}

?>