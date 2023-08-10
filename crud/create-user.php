<?php

// Function to generate a random 4-digit OTP
function generateOTP() {
    return strval(rand(1000, 9999));
}

// Function to generate a random bearer token
function generateBearerToken() {
    return bin2hex(random_bytes(12)); // Generate a 12-byte random string as a token
}

// Function to generate a random user ID
function generateRandomUserID() {
    // Generate a random 4-digit number
    $randomNumber = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

    // Get the current date and time in the format: YYYYMMDD_HHMMSS
    $dateTime = date('Ymd_His');

    // Combine the random number and date-time to create the user ID
    $userID = $dateTime . '_' . $randomNumber;

    return $userID;
}

// Function to handle user registration or login
function userRegistrationOrLogin() {
    global $conn, $phoneNumber;

    // Assuming the phone number is sent in the request body as a JSON field called 'phone_number'
    $data = json_decode(file_get_contents('php://input'), true);
    $phoneNumber = $data['phone_number'];
    
    echo "Received phone number: " . $phoneNumber;


    try {
        // Fetch the user by phone number
        $stmt = $conn->prepare('SELECT * FROM users WHERE user_phone_num = :phone_number');
        $stmt->bindParam(':phone_number', $phoneNumber);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            // If the user does not exist, perform user registration
            // Generate OTP, bearer token, and save to the database
            $otp = generateOTP();
            $bearerToken = generateBearerToken();
            $userID = generateRandomUserID();

            // Insert the new user into the database
            $stmt = $conn->prepare('INSERT INTO users (user_id, user_phone_num, otp, acc_token) VALUES (:user_id, :phone_number, :otp, :bearer_token)');
            $stmt->bindParam(':user_id', $userID);
            $stmt->bindParam(':phone_number', $phoneNumber);
            $stmt->bindParam(':otp', $otp);
            $stmt->bindParam(':bearer_token', $bearerToken);
            $stmt->execute();

            // Return the bearer token, user ID, and actual OTP to the user
            header('Content-Type: application/json');
            echo json_encode(array(
                'status' => 'success',
                'message' => 'User registered successfully',
                'user_id' => $userID,
                'phone_number' => $phoneNumber,
                'bearer_token' => $bearerToken,
                'otp' => $otp
            ));
        } else {
            // If the user already exists, return the user data in JSON format
            header('Content-Type: application/json');
            echo json_encode(array(
                'status' => 'success',
                'message' => 'User already exists',
                'user' => array(
                    'user_id' => $user['user_id'],
                    'user_phone_num' => $user['user_phone_num'],
                    'otp' => $user['otp'],
                    'acc_token' => $user['acc_token']
                )
            ));
        }
    } catch (PDOException $e) {
        // Handle database connection error or query error
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(array('error' => 'Internal Server Error'));
        die();
    }
}

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
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$endpoints = array(
    '/API/V1/login-api.php' => 'userRegistrationOrLogin'
);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($endpoints[$url])) {
    $functionName = $endpoints[$url];
    $functionName();
} else {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(array('error' => 'Not Found'));
}

?>
