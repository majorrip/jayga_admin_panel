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

// Initialize arrays to store error and success messages
$errors = array();
$success = false; // Initialize a success flag

// Handle RESTful API routing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $listing_id = $_POST['listing_id'];
    $lister_id = $_POST['lister_id'];

    // Check if files were uploaded
    if (!empty($_FILES['listing_pictures']['name'][0])) {
        // Iterate through the uploaded files
        foreach ($_FILES['listing_pictures']['name'] as $i => $file_name) {
            $file_tmp = $_FILES['listing_pictures']['tmp_name'][$i];
            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            $allowed_extensions = array('jpg', 'jpeg', 'png', 'bmp');
            if (in_array($file_extension, $allowed_extensions)) {
                // Generate a unique filename
                $file_name = $listing_id . "-" . $lister_id . "_listing-pic_" . date("YmdHis") . "_" . rand(1000, 9999) . "." . $file_extension;

                // Create a new folder with the name as the listing_id (if it doesn't exist)
                $upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/lister/listings/";
                $listing_folder = $upload_dir . $listing_id . "/";
                if (!is_dir($listing_folder)) {
                    mkdir($listing_folder, 0777, true);
                }

                // Save the image to the server
                $target_file = $listing_folder . $file_name;
                if (move_uploaded_file($file_tmp, $target_file)) {
                    // Insert record into the database
                    $sql = "INSERT INTO listing_images (listing_id, lister_id, listing_filename, listing_targetlocation) VALUES (?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$listing_id, $lister_id, $file_name, $target_file]);
                    $stmt->closeCursor();

                    // Set the success flag to true
                    $success = true;
                } else {
                    // Add error message to the array
                    $errors[] = "Error saving the image '$file_name'.";
                }
            } else {
                // Add error message to the array
                $errors[] = "Invalid image format for file: $file_name";
            }
        }
    } else {
        // Add error message to the array
        $errors[] = "No files were uploaded.";
    }

    // Prepare the response data
    $response = array();
    if (!empty($errors)) {
        $response['error'] = implode("\n", $errors);
    }
    if ($success) {
        $response['message'] = "Image uploaded successfully.";
    }

    // Send a single JSON response with both error and success messages
    echo json_encode($response);
} else {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(array('error' => 'Not Found'));
}
?>
