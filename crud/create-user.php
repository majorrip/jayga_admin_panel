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


    function generateRandomUserID() {
        // Generate a random 4-digit number
        $randomNumber = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
    
        // Get the current date and time in the format: YYYYMMDD_HHMMSS
        $dateTime = date('Ymd_His');
    
        // Combine the random number and date-time to create the user ID
        $userID = $dateTime . '_' . $randomNumber;
    
        return $userID;
    }

    $userid = generateRandomUserID();
    $customerName = $_POST["name"];
    $customerEmail = $_POST["email"];
    $phoneNumber = $_POST["phone"];
    $userNID = $_POST["nid"];
    $birthDate = $_POST["birthdate"];
    $a_host = $_POST["a_host"];
    $customerAddress = $_POST["address"];

    $platform_tag = 0;

    // Insert the form data into the database
    $sql = "INSERT INTO users (user_id, user_name, user_email, user_phone_num, user_nid, user_dob, user_address,is_lister,platform_tag)
            VALUES ('$userid','$customerName', '$customerEmail', '$phoneNumber', '$userNID', '$birthDate', '$customerAddress', '$a_host','0')";


    if ($conn->query($sql) === TRUE) {
        // Data inserted successfully
        echo "Customer data inserted into the user database.\n";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    if ($a_host == 1){

        $sql1 = "INSERT INTO lister_user (user_id, lister_name, lister_email, lister_phone_num, lister_nid, lister_dob, lister_address, platform_tag)
                VALUES ('$userid','$customerName', '$customerEmail', '$phoneNumber', '$userNID', '$birthDate', '$customerAddress', '0')";
        
        if ($conn->query($sql1) === TRUE) {
            // Data inserted successfully
            echo "Customer data inserted into the lister database.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        if (isset($_FILES["user_nid"])) {
            $num_files = count($_FILES["user_nid"]["name"]);
            for ($i = 0; $i < $num_files; $i++) {
                if ($_FILES["user_nid"]["error"][$i] == 0) {
                    // Check if file is an image
                    $file_type = $_FILES["user_nid"]["type"][$i];
                    if (($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "image/jpg") || ($file_type == "image/bmp")) {
                        // Generate unique file name based on current date and time
                        $file_name3 = $_FILES["user_nid"]["name"][$i];
                        $file_extension3 = pathinfo($file_name3, PATHINFO_EXTENSION);
                        $file_name3 = $userid . "_NID_". date("YmdHis") . "_" . rand(1000, 9999) . "." . $file_extension3;
                        
                        // Move file to permanent location on server (for lister_nid)
                        $temp_name3 = $_FILES["user_nid"]["tmp_name"][$i];
                        $upload_dir3 = "../uploads/lister/lister_nid/";
                        $target_file3 = $upload_dir3 . basename($file_name3);
                        move_uploaded_file($temp_name3, $target_file3);
        
                        // Copy file to permanent location on server (for user_nid)
                        $upload_dir_user = "../uploads/user/user_nid/";
                        $target_file_user = $upload_dir_user . basename($file_name3);
                        copy($target_file3, $target_file_user);

                        
        
                        // Insert record into database (for lister_nid)
                        $sql_list3 = "INSERT INTO lister_nid (lister_user_id, lister_nid_pic_name, listing_nid_pic_location) VALUES ('$userid','$file_name3', '$target_file3')";
                        if (mysqli_query($conn, $sql_list3)) {
                            echo "nid uploaded successfully as a lister\n";
                        } else {
                            echo "Error: " . $sql_list . "
                            <br>" . mysqli_error($conn);
                        }

                        // Insert record into database (for user_nid)
                        $sql_list3 = "INSERT INTO user_nid (user_id, user_nid_filename, user_nid_targetlocation) VALUES ('$userid','$file_name3', '$target_file_user')";
                        if (mysqli_query($conn, $sql_list3)) {
                            echo "nid uploaded successfully as a lister\n";
                        } else {
                            echo "Error: " . $sql_list . "
                            <br>" . mysqli_error($conn);
                        }
                    }
                }
            }
        }
        
        
    }
    
    // Check if profile_pic were uploaded
    if (isset($_FILES["user_pic"])) {
        $num_files = count($_FILES["user_pic"]["name"]);
        for ($i = 0; $i < $num_files; $i++) {
            if ($_FILES["user_pic"]["error"][$i] == 0) {
                // Check if file is an image
                $file_type = $_FILES["user_pic"]["type"][$i];
                if (($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "image/jpg") || ($file_type == "image/bmp")) {
                    // Generate unique file name based on current date and time
                    $file_name1 = $_FILES["user_pic"]["name"][$i];
                    $file_extension1 = pathinfo($file_name1, PATHINFO_EXTENSION);
                    $file_name1 = $userid . "_profile-pic_". date("YmdHis") . "_" . rand(1000, 9999) . "." . $file_extension1;
                    
                    // Move file to permanent location on server
                    $temp_name1 = $_FILES["user_pic"]["tmp_name"][$i];
                    $upload_dir1 = "../uploads/user/profile_pic/";
                    $target_file1 = $upload_dir1 . basename($file_name1);
                    move_uploaded_file($temp_name1, $target_file1);
    
                    // Insert record into database
                    $sql_list1 = "INSERT INTO user_pictures (user_id, user_filename, user_targetlocation) VALUES ('$userid','$file_name1', '$target_file1')";
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

    if (isset($_FILES["user_nid"])) {
    $num_files = count($_FILES["user_nid"]["name"]);
    for ($i = 0; $i < $num_files; $i++) {
        if ($_FILES["user_nid"]["error"][$i] == 0) {
            // Check if file is an image
            $file_type = $_FILES["user_nid"]["type"][$i];
            if (($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "image/jpg") || ($file_type == "image/bmp")) {
                // Generate unique file name based on current date and time
                $file_name1 = $_FILES["user_nid"]["name"][$i];
                $file_extension1 = pathinfo($file_name1, PATHINFO_EXTENSION);
                $file_name1 = $userid . "_user-nid_". date("YmdHis") . "_" . rand(1000, 9999) . "." . $file_extension1;

                // Move file to permanent location on server
                $temp_name1 = $_FILES["user_nid"]["tmp_name"][$i];
                $upload_dir1 = "../uploads/user/user_nid/";
                $target_file1 = $upload_dir1 . basename($file_name1);

                // Validate if the file was successfully moved
                if (move_uploaded_file($temp_name1, $target_file1)) {
                    // Insert record into database
                    $sql_list1 = "INSERT INTO user_nid (user_id, user_nid_filename, user_nid_targetlocation) VALUES ('$userid','$file_name1', '$target_file1')";
                    if (mysqli_query($conn, $sql_list1)) {
                        echo "User NID uploaded successfully.\n";
                    } else {
                        echo "Error inserting NID record into the database: " . mysqli_error($conn) . "\n";
                    }
                } else {
                    echo "Error moving NID file to the target location.\n";
                }
            } else {
                echo "Invalid file type. Only JPEG, PNG, JPG, and BMP images are allowed.\n";
            }
        } else {
            echo "Error uploading NID file: " . $_FILES["user_nid"]["error"][$i] . "\n";
        }
    }
}



    // Close the database connection
    header("Location: ../add-user.php");
            $conn->close();
	        exit(); 
}
?>