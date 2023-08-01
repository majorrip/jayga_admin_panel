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

    // Add this line to check if the script receives the data
    echo "Form data submitted successfully.\n";

    $userid = $_POST["user_id"]; // Assuming you have a form field for the user ID

    var_dump($_POST);
    
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
        $is_lister = isset($_POST["is_lister"]) ? $_POST["is_lister"] : 0;
        $userAddress = $_POST["address"];

        $platform_tag = 0;

        $update_sql = "UPDATE users SET user_name='$userName', user_email='$userEmail', user_phone_num='$phoneNumber', 
                    user_nid='$userNID', user_dob='$birthDate', user_address='$userAddress', is_lister='$is_lister', 
                    platform_tag='$platform_tag' WHERE user_id='$userid'";

    // Add this echo statement to check the query
    echo "Update User Query: " . $update_sql . "\n";

    if ($conn->query($update_sql) === TRUE) {
        // Data updated successfully
        echo "User data updated in the user database.\n";
    } else {
        // Display the error message
        echo "Error updating user data: " . mysqli_error($conn) . "\n";
    }


    // Assuming the previous code here...

if ($is_lister == 1) {
    // Update the lister data in the database using the INSERT INTO ... ON DUPLICATE KEY UPDATE query
    $update_sql1 = "INSERT INTO lister_user (user_id, lister_name, lister_email, lister_phone_num, lister_nid, lister_dob, lister_address, platform_tag)
                    VALUES ('$userid', '$userName', '$userEmail', '$phoneNumber', '$userNID', '$birthDate', '$userAddress', '$platform_tag')
                    ON DUPLICATE KEY UPDATE
                    lister_name='$userName', lister_email='$userEmail', lister_phone_num='$phoneNumber', 
                    lister_nid='$userNID', lister_dob='$birthDate', lister_address='$userAddress', platform_tag='$platform_tag'";
    
    if ($conn->query($update_sql1) === TRUE) {
        // Data updated or inserted successfully
        echo "User data updated in the lister database.\n";
    } else {
        echo "Error: " . $update_sql1 . "<br>" . $conn->error;
    }
} else {
    // Delete the user from the lister_user table since is_lister is 0
    
    // Check if the user exists in the lister_user table before attempting to delete
    $check_lister_sql = "SELECT user_id FROM lister_user WHERE user_id = '$userid'";
    $result_lister = $conn->query($check_lister_sql);
    
    if ($result_lister->num_rows === 0) {
        // User does not exist in lister_user table, nothing to delete
        echo "User does not exist in the lister_user table. No action needed.\n";
    } else {
        // User exists in lister_user table, so delete the user
        $delete_lister_sql = "DELETE FROM lister_user WHERE user_id='$userid'";
        if ($conn->query($delete_lister_sql) === TRUE) {
            echo "User deleted from the lister_user table.\n";
        } else {
            echo "Error: " . $delete_lister_sql . "<br>" . $conn->error;
        }
    }
}

// ... Continue with the rest of your code

    
    }
    
    // Check if profile_pic was uploaded and update the database
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Add this line to check if the script receives the data
        echo "Form data submitted successfully.\n";

        function deletePreviousProfilePicture($user_id)
{
            $query = "SELECT user_targetlocation FROM user_pictures WHERE user_id=?";
            global $conn;
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $user_id);
            $stmt->execute();
            $stmt->bind_result($user_targetlocation);
            $stmt->fetch();
            $stmt->close();

            // Check if the previous profile picture exists and delete it
            if (file_exists($user_targetlocation)) {
                unlink($user_targetlocation);
            }
}
    
        // Check if the file was uploaded
        if (isset($_FILES["user_pic"]) && is_array($_FILES["user_pic"]["error"])) {
            foreach ($_FILES["user_pic"]["error"] as $key => $error) {
                if ($error === 0) {

                    // Delete the previous profile picture before uploading the new one
                    deletePreviousProfilePicture($_POST["user_id"]);


                    // Check if file is an image
                    $file_type = $_FILES["user_pic"]["type"][$key];
                    if (in_array($file_type, array("image/jpeg", "image/png", "image/jpg", "image/bmp"))) {
                        // Generate unique file name based on current date and time
                        $file_name1 = $_POST["user_id"] . "_profile-pic_" . date("YmdHis") . "_" . rand(1000, 9999) . "." . pathinfo($_FILES["user_pic"]["name"][$key], PATHINFO_EXTENSION);
        
                        // Move file to permanent location on server
                        $temp_name1 = $_FILES["user_pic"]["tmp_name"][$key];
                        $upload_dir1 = "../uploads/user/profile_pic/";
                        $target_file1 = $upload_dir1 . basename($file_name1);
                        if (move_uploaded_file($temp_name1, $target_file1)) {
                            // Update the database with the new profile picture information using prepared statement
                            $update_sql1 = "UPDATE user_pictures SET user_filename=?, user_targetlocation=? WHERE user_id=?";
                            $stmt = $conn->prepare($update_sql1);
                            $stmt->bind_param("sss", $file_name1, $target_file1, $_POST["user_id"]);
                            if ($stmt->execute()) {
                                echo "Profile picture updated successfully for user.\n";
                            } else {
                                echo "Error updating profile picture in the database: " . $stmt->error . "\n";
                            }
                            $stmt->close();
                        } else {
                            echo "Error moving the profile picture file.\n";
                        }
                    } else {
                        echo "Invalid file type for file " . $_FILES["user_pic"]["name"][$key] . ". Only JPEG, PNG, JPG, and BMP images are allowed for profile pictures.\n";
                    }
                }
            }
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
    header("Location: ../edit-user.php");
    $conn->close();
    exit(); 
}
?>
