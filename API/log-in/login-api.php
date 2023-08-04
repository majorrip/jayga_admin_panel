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
    $host = 'your_host';
    $username = 'your_username';
    $password = 'your_password';
    $dbname = 'your_database_name';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch the user data from the database based on the phone number
        $stmt = $conn->prepare('SELECT * FROM users WHERE phone_number = :phone_number');
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

// API endpoint for user registration and login
function userRegistrationAndLogin() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Assuming the phone number is sent in the request body as a JSON field called 'phone_number'
        $data = json_decode(file_get_contents('php://input'), true);
        $phoneNumber = $data['phone_number'];

        // Generate a random 4-digit OTP
        $otp = generateOTP();

        // Securely hash the OTP before saving to the database
        $hashedOtp = hashOTP($otp);

        // Generate a more secure bearer token
        $bearerToken = generateBearerToken();

        // Implement your database connection logic here
        $host = 'your_host';
        $username = 'your_username';
        $password = 'your_password';
        $dbname = 'your_database_name';

        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Save the user data to the database
            $stmt = $conn->prepare('INSERT INTO users (phone_number, otp, bearer_token) VALUES (:phone_number, :otp, :bearer_token)');
            $stmt->bindParam(':phone_number', $phoneNumber);
            $stmt->bindParam(':otp', $hashedOtp);
            $stmt->bindParam(':bearer_token', $bearerToken);
            $stmt->execute();

            // Send the OTP to the user via SMS or any other method
            // You can implement the SMS sending logic here

            // Return the bearer token and actual OTP to the user (for demonstration purposes)
            header('Content-Type: application/json');
            echo json_encode(array(
                'bearer_token' => $bearerToken,
                'otp' => $otp
            ));
        } catch (PDOException $e) {
            // Handle database connection error
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(array('error' => 'Internal Server Error'));
            die();
        }
    }
}

// API endpoint for login
function userLogin() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Assuming the phone number, OTP, and bearer token are sent in the request body as JSON fields
        $data = json_decode(file_get_contents('php://input'), true);
        $phoneNumber = $data['phone_number'];
        $otp = $data['otp'];
        $bearerToken = $data['bearer_token'];

        // Implement your database connection logic here
        $host = 'your_host';
        $username = 'your_username';
        $password = 'your_password';
        $dbname = 'your_database_name';

        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Fetch the user data from the database based on the phone number
            $user = fetchUserByPhoneNumber($phoneNumber);

            if ($user && password_verify($otp, $user['otp']) && isValidBearerToken($bearerToken)) {
                // If the phone number, OTP, and bearer token match, return the user ID and phone number
                header('Content-Type: application/json');
                echo json_encode(array(
                    'status' => 'OK',
                    'access_token' => $bearerToken,
                    'token_type' => 'bearer',
                    'message' => 'You have successfully logged in',
                    'user' => array(
                        'id' => $user['id'],
                        'phone' => $user['phone'],
                        'otp' => $otp
                    )
                ));
            } else {
                // If validation fails, return an error response
                header('HTTP/1.1 401 Unauthorized');
                echo json_encode(array('error' => 'Unauthorized'));
            }
        } catch (PDOException $e) {
            // Handle database connection error
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(array('error' => 'Internal Server Error'));
            die();
        }
    }
}

// Call the API function based on the endpoint (registration or login)
if ($_SERVER['REQUEST_URI'] === '/userRegistrationAndLogin') {
    userRegistrationAndLogin();
} elseif ($_SERVER['REQUEST_URI'] === '/userLogin') {
    userLogin();
} else {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(array('error' => 'Not Found'));
}
