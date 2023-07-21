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
    $customerAddress = $_POST["address"];

    // Insert the form data into the database
    $sql = "INSERT INTO users (user_id, user_name, user_email, user_phone_num, user_nid, user_dob, user_address)
            VALUES ('$userid','$customerName', '$customerEmail', '$phoneNumber', '$userNID', '$birthDate', '$customerAddress')";

    if ($conn->query($sql) === TRUE) {
        // Data inserted successfully
        echo "Customer data inserted into the database.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
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
                    $file_name2 = $_FILES["user_pic"]["name"][$i];
                    $file_extension = pathinfo($file_name2, PATHINFO_EXTENSION);
                    $file_name2 = $userid . "_profile-pic_". date("YmdHis") . "_" . rand(1000, 9999) . "." . $file_extension;
                    
                    // Move file to permanent location on server
                    $temp_name = $_FILES["user_pic"]["tmp_name"][$i];
                    $upload_dir = "uploads/user/profile_pic/";
                    $target_file2 = $upload_dir . basename($file_name2);
                    move_uploaded_file($temp_name, $target_file2);
    
                    // Insert record into database
                    $sql_list = "INSERT INTO user_pictures (user_id, user_filename, user_targetlocation) VALUES ('$userid','$file_name2', '$target_file2')";
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
    header("Location: ../add-user.php");
            $conn->close();
	        exit(); 
}
?>
