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

// Check if the listing_id parameter is provided in the GET request
if (isset($_GET['listing_id']) && is_numeric($_GET['listing_id'])) {
    $listingId = $_GET['listing_id'];

    // Prepare and execute a SELECT query to fetch image file paths from the database
    $query = "SELECT listing_targetlocation FROM listing_images WHERE listing_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $listingId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are rows returned from the query
    if ($result->num_rows > 0) {
        $imagePaths = array();

        // Fetch the image file paths and store them in an array
        while ($row = $result->fetch_assoc()) {
            $imagePaths[] = $row["listing_targetlocation"];
        }

        // Return the image paths as a JSON response
        header("Content-Type: application/json");
        echo json_encode($imagePaths);
        exit();
    } else {
        // If no images found, return an empty JSON array
        header("Content-Type: application/json");
        echo json_encode(array());
        exit();
    }
} else {
    // If listing_id parameter is missing or not valid, return an error JSON response
    header("HTTP/1.1 400 Bad Request");
    header("Content-Type: application/json");
    echo json_encode(array("error" => "Invalid or missing listing_id parameter"));
    exit();
}
