<?php

// Function to generate a random 4-digit OTP
function generateOTP() {
    return strval(rand(1000, 9999));
}

// Function to generate a random bearer token
function generateBearerToken() {
    return bin2hex(random_bytes(32)); // Generate a 32-byte random string as a token
}

// Function to hash the OTP securely
function hashOTP($otp) {
    return password_hash($otp, PASSWORD_BCRYPT);
}

// Function to validate the Bearer Token
function isValidBearerToken($bearerToken) {
    // Implement your validation logic here
    // For example, check if the bearer token exists in the database and is associated with a valid user
    // This is a placeholder, and you should replace it with your own validation logic
    return !empty($bearerToken);
}

// Function to fetch user data by phone number from the database
function fetchUserByPhoneNumber($phoneNumber) {
    // Implement your database connection logic here
    $host = 'podma-bd-cp1';
    $username = 'jaygabdc_atif_admin';
    $password = 'jaygabd_atif_123';
    $dbname = 'jaygabdc_jayga_db_1';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch the user data from the database based on the phone number
        $stmt = $conn->prepare('SELECT * FROM users WHERE user_phone_num = :phone_number');
        $stmt->bindParam(':phone_number', $phoneNumber);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user;
    } catch (PDOException $e) {
        // Handle database connection error
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(array('error' => 'Internal Server Error'));
        die();
    }
}

// API endpoint for user registration
function userRegistration() {
    global $phoneNumber;

    // Assuming the phone number is sent in the request body as a JSON field called 'phone_number'
    $data = json_decode(file_get_contents('php://input'), true);
    $phoneNumber = $data['phone_number'];

    // Fetch the user by phone number
    $user = fetchUserByPhoneNumber($phoneNumber);

    if (!$user) {
        // If the user does not exist, generate OTP, bearer token, and save to the database
        $otp = generateOTP();
        $hashedOtp = hashOTP($otp);
        $bearerToken = generateBearerToken();

        // Implement your database connection logic here
        $host = 'podma-bd-cp1';
        $username = 'jaygabdc_atif_admin';
        $password = 'jaygabd_atif_123';
        $dbname = 'jaygabdc_jayga_db_1';

        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Insert the new user into the database
            $stmt = $conn->prepare('INSERT INTO users (user_phone_num, otp, acc_token) VALUES (:phone_number, :otp, :bearer_token)');
            $stmt->bindParam(':phone_number', $phoneNumber);
            $stmt->bindParam(':otp', $hashedOtp);
            $stmt->bindParam(':bearer_token', $bearerToken);
            $stmt->execute();

            // Return the bearer token and actual OTP to the user
            header('Content-Type: application/json');
            echo json_encode(array(
                'status' => 'success',
                'message' => 'User registered successfully',
                'bearer_token' => $bearerToken,
                'otp' => $otp
            ));
        } catch (PDOException $e) {
            // Handle database connection error or insert error
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(array('error' => 'Internal Server Error'));
            die();
        }
    } else {
        // If the user already exists, return an error response
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(array('error' => 'User already registered'));
    }
}

// API endpoint for user login
function userLogin() {
    global $phoneNumber;

    // Assuming the phone number, OTP, and bearer token are sent in the request body as JSON fields
    $data = json_decode(file_get_contents('php://input'), true);
    $phoneNumber = $data['phone_number'];
    $otp = $data['otp'];
    $bearerToken = $data['bearer_token'];

    // Fetch the user by phone number
    $user = fetchUserByPhoneNumber($phoneNumber);

    if ($user && password_verify($otp, $user['otp']) && isValidBearerToken($bearerToken)) {
        // If the phone number, OTP, and bearer token match, return the user data
        header('Content-Type: application/json');
        echo json_encode(array(
            'status' => 'success',
            'message' => 'User logged in successfully',
            'user' => array(
                'phone' => $phoneNumber,
                'otp' => $otp
            )
        ));
    } else {
        // If validation fails, return an error response
        header('HTTP/1.1 401 Unauthorized');
        echo json_encode(array('error' => 'Unauthorized'));
    }
}

// Handle RESTful API routing
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$endpoints = array(
    '/API/V1/login-api/userRegistration' => 'userRegistration',
    '/API/V1/login-api/userLogin' => 'userLogin'
);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($endpoints[$url])) {
    $functionName = $endpoints[$url];
    $functionName();
} else {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(array('error' => 'Not Found'));
}
