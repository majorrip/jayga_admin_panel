<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate and sanitize the input data (you can add more validation as needed)
    $lister_id = isset($_POST["selected_lister_id"]) ? $_POST["selected_lister_id"] : "";
    $lister_name = isset($_POST["selected_lister_name"]) ? $_POST["selected_lister_name"] : "";
    $guest_num = isset($_POST["guest_num"]) ? $_POST["guest_num"] : "";
    $bedroom_num = isset($_POST["bedroom_num"]) ? $_POST["bedroom_num"] : "";
    $bathroom_num = isset($_POST["bathroom_num"]) ? $_POST["bathroom_num"] : "";
    $listing_title = isset($_POST["listing_title"]) ? $_POST["listing_title"] : "";
    $describe_listing = isset($_POST["describe_listing"]) ? $_POST["describe_listing"] : "";
    $price = isset($_POST["price"]) ? $_POST["price"] : "";
    $listing_address = isset($_POST["listing_address"]) ? $_POST["listing_address"] : "";
    $zip_code = isset($_POST["zip_code"]) ? $_POST["zip_code"] : "";
    $district = isset($_POST["district"]) ? $_POST["district"] : "";
    $town = isset($_POST["town"]) ? $_POST["town"] : "";
    $allow_short_stay = isset($_POST["allow_short_stay"]) ? 1 : 0;
    $is_it_peaceful = isset($_POST["is_it_peaceful"]) ? 1 : 0;
    $is_it_unique = isset($_POST["is_it_unique"]) ? 1 : 0;
    $is_it_family_friendly = isset($_POST["is_it_family_friendly"]) ? 1 : 0;
    $is_it_stylish = isset($_POST["is_it_stylish"]) ? 1 : 0;
    $is_it_central = isset($_POST["is_it_central"]) ? 1 : 0;
    $is_it_spacious = isset($_POST["is_it_spacious"]) ? 1 : 0;
    $private_bathroom = isset($_POST["private_bathroom"]) ? 1 : 0;
    $breakfast_available = isset($_POST["breakfast_available"]) ? 1 : 0;
    $room_lock = isset($_POST["room_lock"]) ? 1 : 0;
    $anyone_else = isset($_POST["anyone_else"]) ? 1 : 0;
    $listing_type = isset($_POST["listing_type"]) ? $_POST["listing_type"] : "";

    // Database connection credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "jayga_db_1";

    // Create a database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to insert the data into the table
    $sql = "INSERT INTO listing (lister_id, lister_name, guest_num, bed_num, bathroom_num, listing_title, listing_description, full_day_price_set_by_user, listing_address, zip_code, district, town, allow_short_stay, describe_peaceful, describe_unique, describe_familyfriendly, describe_stylish, describe_central, describe_spacious, bathroom_private, breakfast_availability, room_lock, who_else_might_be_there, listing_type) 
            VALUES ('$lister_id', '$lister_name', '$guest_num', '$bedroom_num', '$bathroom_num', '$listing_title', '$describe_listing', '$price', '$listing_address', '$zip_code', '$district', '$town', '$allow_short_stay', '$is_it_peaceful', '$is_it_unique', '$is_it_family_friendly', '$is_it_stylish', '$is_it_central', '$is_it_spacious', '$private_bathroom', '$breakfast_available', '$room_lock', '$anyone_else', '$listing_type')";


    if ($conn->query($sql) === TRUE) {
        echo "Listing created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $listing_id = mysqli_insert_id($conn);

if (isset($_FILES["listing_pictures"])) {
    $num_files = count($_FILES["listing_pictures"]["name"]);
    for ($i = 0; $i < $num_files; $i++) {
        if ($_FILES["listing_pictures"]["error"][$i] == 0) {
            // Check if file is an image
            $file_type = $_FILES["listing_pictures"]["type"][$i];
            if (($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "image/jpg") || ($file_type == "image/bmp")) {
                // Generate unique file name based on current date and time
                $file_name1 = $_FILES["listing_pictures"]["name"][$i];
                $file_extension1 = pathinfo($file_name1, PATHINFO_EXTENSION);
                $file_name1 = $listing_id ."-". $lister_id . "_listing-pic_". date("YmdHis") . "_" . rand(1000, 9999) . "." . $file_extension1;

                // Create a new folder with the name as the listing_id (if it doesn't exist)
                $upload_dir1 = "../uploads/lister/listings/";
                $listing_folder = $upload_dir1 . $listing_id . "/";
                if (!is_dir($listing_folder)) {
                    mkdir($listing_folder, 0777, true);
                }

                // Move file to permanent location on the server inside the listing_id folder
                $temp_name1 = $_FILES["listing_pictures"]["tmp_name"][$i];
                $target_file1 = $listing_folder . basename($file_name1);
                move_uploaded_file($temp_name1, $target_file1);

                // Insert record into the database
                $sql_list1 = "INSERT INTO listing_images (listing_id, lister_id, listing_filename, listing_targetlocation) VALUES ('$listing_id','$lister_id', '$file_name1', '$target_file1')";
                if (mysqli_query($conn, $sql_list1)) {
                    echo "profile pic uploaded successfully from user\n";
                } else {
                    echo "Error: " . $sql_list . "
                    <br>" . mysqli_error($conn);
                }
            }
        }
    }
}


    // Close the database connection
    header("Location: ../add-listing.php");
    $conn->close();
    exit();
}
?>
