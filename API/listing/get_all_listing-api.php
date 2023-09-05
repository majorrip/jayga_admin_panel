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

// Handle RESTful API routing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $listing_id = $_POST['listing_id'];
    $lister_id = $_POST['lister_id'];

    // Initialize an array to store base64-encoded image data
    $image_data_array = array();

    // Check if files were uploaded
    if (!empty($_FILES['listing_pictures']['name'][0])) {
        // Iterate through the uploaded files
        foreach ($_FILES['listing_pictures']['name'] as $i => $file_name) {
            $file_tmp = $_FILES['listing_pictures']['tmp_name'][$i];
            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            $allowed_extensions = array('jpg', 'jpeg', 'png');
            if (in_array($file_extension, $allowed_extensions)) {
                // Debugging
                echo "Uploading file: " . $file_name . "\n";

                // Read the file into a base64-encoded string
                $file_data = base64_encode(file_get_contents($file_tmp));

                // Debugging
                echo "Base64-encoded file data:\n";
                echo $file_data . "\n";

                // Generate a unique filename
                $file_name = $listing_id . "-" . $lister_id . "_listing-pic_" . date("YmdHis") . "_" . rand(1000, 9999) . "." . $file_extension;

                // Create a new folder with the name as the listing_id (if it doesn't exist)
                $upload_dir = "../uploads/lister/listings/";
                $listing_folder = $upload_dir . $listing_id . "/";
                if (!is_dir($listing_folder)) {
                    mkdir($listing_folder, 0777, true);
                }

                // Save the image to the server
                $target_file = $listing_folder . $file_name;
                if (file_put_contents($target_file, base64_decode($file_data))) {
                    // Add the base64-encoded image data to the array
                    $image_data_array[] = $file_data;
                    
                    // Insert record into the database
                    $sql = "INSERT INTO listing_images (listing_id, lister_id, listing_filename, listing_targetlocation) VALUES (?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$listing_id, $lister_id, $file_name, $target_file]);
                    $stmt->closeCursor();
                } else {
                    echo json_encode(array('error' => 'Error saving the image.'));
                }
            } else {
                echo json_encode(array('error' => 'Invalid image format for file: ' . $file_name));
            }
        }
    } else {
        echo json_encode(array('error' => 'No files were uploaded.'));
    }

    // After processing all uploaded files, return the array of base64-encoded image data
    if (!empty($image_data_array)) {
        echo json_encode(array('message' => 'Images uploaded and records inserted successfully.', 'image_data' => $image_data_array));
    }
} else {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(array('error' => 'Not Found'));
}
?>
