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

    // Initialize an object to store data
    $listing_data = new stdClass();
    $listing_data->listing_id = $listing_id;
    $listing_data->lister_id = $lister_id;
    $listing_data->listing_images = array();

    // Check if files were uploaded
    if (!empty($_FILES['listing_pictures']['name'][0])) {
        // Iterate through the uploaded files
        foreach ($_FILES['listing_pictures']['name'] as $i => $file_name) {
            $file_tmp = $_FILES['listing_pictures']['tmp_name'][$i];
            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            $allowed_extensions = array('jpg', 'jpeg', 'png');
            if (in_array($file_extension, $allowed_extensions)) {
                // Debugging
                // echo "Uploading file: " . $file_name . "<br>";

                // Read the file into a base64-encoded string
                $file_data = base64_encode(file_get_contents($file_tmp));

                // Debugging
                // echo "Base64-encoded file data:<br>";
                // echo $file_data . "<br>";

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
                if (file_put_contents($target_file, base64_decode($file_data))) {
                    // Add the base64-encoded image data to the listing data
                    $listing_data->listing_images[] = array(
                        'listing_picture' => $file_name,
                        'listing_picture_base64' => $file_data
                    );
                    
                    // Insert record into the database
                    $sql = "INSERT INTO listing_images (listing_id, lister_id, listing_filename, listing_targetlocation) VALUES (?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$listing_id, $lister_id, $file_name, $target_file]);
                    $stmt->closeCursor();
                } else {
                    echo json_encode(array('error' => 'Error saving the image.')) . "<br>";
                }
            } else {
                echo json_encode(array('error' => 'Invalid image format for file: ' . $file_name)) . "<br>";
            }
        }
    } else {
        echo json_encode(array('error' => 'No files were uploaded.')) . "<br>";
    }

    // After processing all uploaded files, return the listing data in JSON format
    if (!empty($listing_data->listing_images)) {
        echo json_encode($listing_data) . "<br>";
    }
} else {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(array('error' => 'Not Found')) . "<br>";
}
?>
