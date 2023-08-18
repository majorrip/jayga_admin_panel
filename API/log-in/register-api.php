<?php

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

// Function to update user information
function updateUserInformation() {
    // Check if the required parameters are provided
    if (!isset($_POST['acc_token']) || !isset($_POST['user_name']) || !isset($_POST['user_email']) || !isset($_POST['user_dob'])) {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(array('error' => 'Missing required fields'));
        die();
    }

    // Retrieve parameters
    $acc_token = $_POST['acc_token'];
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_dob = $_POST['user_dob'];

    // Convert the provided user_dob to the MySQL DATE format (YYYY-MM-DD)
    $user_dob_mysql = date('Y-m-d', strtotime($user_dob));

    try {
        // Check if the provided acc_token exists in the database
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM users WHERE acc_token = :acc_token');
        $stmt->bindParam(':acc_token', $acc_token);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            header('HTTP/1.1 404 Not Found');
            echo json_encode(array('error' => 'acc_token does not exist'));
            die();
        }

        // Update user information in the database based on the provided acc_token
        $stmt = $conn->prepare('UPDATE users SET user_name = :user_name, user_email = :user_email, user_dob = :user_dob WHERE acc_token = :acc_token');
        $stmt->bindParam(':user_name', $user_name);
        $stmt->bindParam(':user_email', $user_email);
        $stmt->bindParam(':user_dob', $user_dob_mysql);
        $stmt->bindParam(':acc_token', $acc_token);
        $stmt->execute();

        $affectedRows = $stmt->rowCount();
        if ($affectedRows > 0) {
            // Fetch the updated user data
            $stmt = $conn->prepare('SELECT * FROM users WHERE acc_token = :acc_token');
            $stmt->bindParam(':acc_token', $acc_token);
            $stmt->execute();
            $updatedUser = $stmt->fetch(PDO::FETCH_ASSOC);

            // Output the updated user information in JSON format
            header('Content-Type: application/json');
            echo json_encode(array(
                // 'status' => 'success',
                'message' => 'User information updated successfully',
                'updated_user' => $updatedUser
            ));
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(array('error' => 'Failed to update user information'));
        }
    } catch (PDOException $e) {
        // Handle database connection error or query error
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(array('error' => 'Internal Server Error'));
        die();
    }
}

// Handle RESTful API routing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    updateUserInformation();
} else {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(array('error' => 'Not Found'));
}

?>
