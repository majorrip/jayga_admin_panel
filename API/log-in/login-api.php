<?php

// Function to generate a random token
function generateToken($length = 10) {
    $characters = '0123456789';
    $token = '';
    for ($i = 0; $i < $length; $i++) {
        $token .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $token;
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

// Assuming you have a function to connect to the database
function connectToDatabase() {
    $host = 'your_host';
    $username = 'your_username';
    $password = 'your_password';
    $dbname = 'your_database_name';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        // Handle connection error
        die("Connection failed: " . $e->getMessage());
    }
}

// API endpoint for login or generating token
function loginOrGenerateToken() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Assuming the phone number is sent in the request body as a JSON field called 'phone_number'
        $data = json_decode(file_get_contents('php://input'), true);
        $phoneNumber = $data['phone_number'];

        // Connect to the database
        $conn = connectToDatabase();

        // Check if the phone number exists in the database
        $stmt = $conn->prepare('SELECT * FROM users WHERE phone_number = :phone_number');
        $stmt->bindParam(':phone_number', $phoneNumber);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // If the phone number exists, you can log the user in here
            // Do whatever you need to do for login functionality
            $response = array('message' => 'Logged in successfully');
        } else {
            // If the phone number doesn't exist, generate a random token and user ID and save them to the database
            $token = generateToken();
            $userID = generateRandomUserID();
            $stmt = $conn->prepare('INSERT INTO users (user_id, phone_number, token) VALUES (:user_id, :phone_number, :token)');
            $stmt->bindParam(':user_id', $userID);
            $stmt->bindParam(':phone_number', $phoneNumber);
            $stmt->bindParam(':token', $token);
            $stmt->execute();
            $response = array('message' => 'User ID and Token generated and saved');
        }

        // Send the response back to the client
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

// Call the API function
loginOrGenerateToken();
