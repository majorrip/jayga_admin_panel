<?php
// Assuming you have a database connection established
// Replace these with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jayga_db_1";

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $customerName = $_POST["name"];
    $customerEmail = $_POST["email"];
    $phoneNumber = $_POST["phone"];
    $userNID = $_POST["nid"];
    $birthDate = $_POST["birthdate"];
    $customerAddress = $_POST["address"];

    // Insert the form data into the database
    $sql = "INSERT INTO users (user_name, user_email, user_phone_number, user_nid, user_dob, user_address)
            VALUES ('$customerName', '$customerEmail', '$phoneNumber', '$userNID', '$birthDate', '$customerAddress')";

    if ($conn->query($sql) === TRUE) {
        // Data inserted successfully
        echo "Customer data inserted into the database.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

     // Check if nid_files were uploaded
     if (isset($_FILES["user_nid"])) {
        $num_files = count($_FILES["user_nid"]["name"]);
        for ($i = 0; $i < $num_files; $i++) {
            if ($_FILES["user_nid"]["error"][$i] == 0) {
                // Check if file is an image
                $file_type = $_FILES["user_nid"]["type"][$i];
                if (($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "image/jpg")) {
                    // Generate new file name based on current date and time
                    $current_date = date('Y-m-d H:i:s');
                    $original_name = $_FILES["user_nid"]["name"][$i];
                    $file_extension = pathinfo($original_name, PATHINFO_EXTENSION);
                    $new_file_name = $current_date . "-" . $original_name . "." . $file_extension;
                    
                    // Move file to permanent location on server with new name
                    $temp_name = $_FILES["user_nid"]["tmp_name"][$i];
                    $upload_dir = "uploads/nid/";
                    $target_file1 = $upload_dir . basename($new_file_name);
                    move_uploaded_file($temp_name, $target_file1);
    
                    // Insert record into database with new file name
                    $sql_nid = "INSERT INTO nid_images (file_name1, target_file1) VALUES ('$new_file_name', '$target_file1')";
                    if (mysqli_query($conn, $sql_nid)) {
                        echo "NID image uploaded successfully";
                    } else {
                        echo "Error: " . $sql_nid . "<br>" . mysqli_error($conn);
                    }
                } else {
                    echo "Error: NID image must be in JPG or PNG format";
                }
            } else {
                echo "Error uploading NID image: " . $_FILES["nid_image"]["error"][$i];
            }
        }
    }



        
        
    
    // Check if listing_files were uploaded without errors "YmdHis" (Year, Month, Day, Hour, Minute, Second)
        if (isset($_FILES["user_pic"])) {
            $num_files = count($_FILES["user_pic"]["name"]);
            for ($i = 0; $i < $num_files; $i++) {
                if ($_FILES["user_pic"]["error"][$i] == 0) {
                    // Check if file is an image
                    $file_type = $_FILES["user_pic"]["type"][$i];
                    if (($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "image/jpg") || ($file_type == "image/bmp")) {
                        // Generate unique file name based on current date and time
                        $file_name2 = $_FILES["user_pic"]["name"][$i];
                        $file_extension = pathinfo($file_name2, PATHINFO_EXTENSION);
                        $file_name2 = "listing_" . date("YmdHis") . "_" . rand(1000, 9999) . "." . $file_extension;
                        
                        // Move file to permanent location on server
                        $temp_name = $_FILES["user_pic"]["tmp_name"][$i];
                        $upload_dir = "uploads/listing/";
                        $target_file2 = $upload_dir . basename($file_name2);
                        move_uploaded_file($temp_name, $target_file2);
        
                        // Insert record into database
                        $sql_list = "INSERT INTO user_pictures (file_name2, target_file2) VALUES ('$file_name2', '$target_file2')";
                        if (mysqli_query($conn, $sql_list)) {
                            echo "File uploaded successfully";
                        } else {
                            echo "Error: " . $sql_list . "
                            <br>" . mysqli_error($conn);
                        }
                    }
                }
            }
        }


    // Close the database connection
    header("Location: add-user.php");
            $conn->close();
	        exit(); 
}
?>
