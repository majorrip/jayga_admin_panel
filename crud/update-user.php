<?php
// Assuming you have a database connection established
// Replace these with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jayga_db_1";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $userid = $_POST["userid"]; // Assuming you have a form field for the user ID
    
    // Check if the user ID exists in the database
    $check_sql = "SELECT user_id FROM users WHERE user_id = '$userid'";
    $result = $conn->query($check_sql);
    
    if ($result->num_rows === 0) {
        echo "User ID not found in the database. Please check the user ID and try again.";
    } else {
        $userName = $_POST["name"];
        $userEmail = $_POST["email"];
        $phoneNumber = $_POST["phone"];
        $userNID = $_POST["nid"];
        $birthDate = $_POST["birthdate"];
        $a_host = $_POST["a_host"];
        $userAddress = $_POST["address"];

        $platform_tag = 0;

        // Update the user data in the database
        $update_sql = "UPDATE users SET user_name='$userName', user_email='$userEmail', user_phone_num='$phoneNumber', 
                        user_nid='$userNID', user_dob='$birthDate', user_address='$userAddress', is_lister='$a_host', 
                        platform_tag='$platform_tag' WHERE user_id='$userid'";

        if ($conn->query($update_sql) === TRUE) {
            // Data updated successfully
            echo "user data updated in the user database.\n";
        } else {
            echo "Error: " . $update_sql . "<br>" . $conn->error;
        }

        if ($a_host == 1) {
            // Update the lister data in the database
            $update_sql1 = "UPDATE lister_user SET lister_name='$userName', lister_email='$userEmail', 
                            lister_phone_num='$phoneNumber', lister_nid='$userNID', lister_dob='$birthDate', 
                            lister_address='$userAddress', platform_tag='$platform_tag' WHERE user_id='$userid'";

            if ($conn->query($update_sql1) === TRUE) {
                // Data updated successfully
                echo "user data updated in the lister database.\n";
            } else {
                echo "Error: " . $update_sql1 . "<br>" . $conn->error;
            }
        }
    }
    
    // Check if profile_pic was uploaded and update the database
    if (isset($_FILES["user_pic"]) && $_FILES["user_pic"]["error"] === 0) {
        // Check if file is an image
        $file_type = $_FILES["user_pic"]["type"];
        if (($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "image/jpg") || ($file_type == "image/bmp")) {
            // Generate unique file name based on current date and time
            $file_name1 = $userid . "_profile-pic_". date("YmdHis") . "_" . rand(1000, 9999) . "." . pathinfo($_FILES["user_pic"]["name"], PATHINFO_EXTENSION);

            // Move file to permanent location on server
            $temp_name1 = $_FILES["user_pic"]["tmp_name"];
            $upload_dir1 = "../uploads/user/profile_pic/";
            $target_file1 = $upload_dir1 . basename($file_name1);
            move_uploaded_file($temp_name1, $target_file1);

            // Update the database with the new profile picture information
            $update_sql1 = "UPDATE user_pictures SET user_filename='$file_name1', user_targetlocation='$target_file1' WHERE user_id='$userid'";
            if (mysqli_query($conn, $update_sql1)) {
                echo "Profile picture updated successfully for user.\n";
            } else {
                echo "Error updating profile picture in the database: " . mysqli_error($conn) . "\n";
            }
        } else {
            echo "Invalid file type. Only JPEG, PNG, JPG, and BMP images are allowed for profile pictures.\n";
        }
    }

    // Check if user_nid file was uploaded and update the database
    if (isset($_FILES["user_nid"]) && $_FILES["user_nid"]["error"] === 0) {
        // Check if file is an image
        $file_type = $_FILES["user_nid"]["type"];
        if (($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "image/jpg") || ($file_type == "image/bmp")) {
            // Generate unique file name based on current date and time
            $file_name2 = $userid . "_user-nid_". date("YmdHis") . "_" . rand(1000, 9999) . "." . pathinfo($_FILES["user_nid"]["name"], PATHINFO_EXTENSION);

            // Move file to permanent location on server
            $temp_name2 = $_FILES["user_nid"]["tmp_name"];
            $upload_dir2 = "../uploads/user/user_nid/";
            $target_file2 = $upload_dir2 . basename($file_name2);
            if (move_uploaded_file($temp_name2, $target_file2)) {
                // Update the database with the new user NID information
                $update_sql2 = "UPDATE user_nid SET user_nid_filename='$file_name2', user_nid_targetlocation='$target_file2' WHERE user_id='$userid'";
                if (mysqli_query($conn, $update_sql2)) {
                    echo "User NID updated successfully.\n";
                } else {
                    echo "Error updating user NID in the database: " . mysqli_error($conn) . "\n";
                }
            } else {
                echo "Error moving NID file to the target location.\n";
            }
        } else {
            echo "Invalid file type. Only JPEG, PNG, JPG, and BMP images are allowed for NID files.\n";
        }
    }

    // Close the database connection
    header("Location: ../add-user.php");
    $conn->close();
    exit(); 
}
?>
