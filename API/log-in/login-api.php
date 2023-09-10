<?php
// Handle database connection
$host = 'podma-bd-cp1';
$username = 'jaygabdc_atif_admin';
$password = 'jaygabd_atif_123';
$dbname = 'jaygabdc_jayga_db_1';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Function to generate a random 6-digit OTP
function generateOTP() {
    return strval(rand(100000, 999999));
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
// Function to handle user registration or login
function handleUserRegistrationOrLogin($conn) {
    // Check if the phone number and FCM token are provided in the form data
    if (isset($_POST['phone_number']) && isset($_POST['fcm_token'])) {
        $phoneNumber = $_POST['phone_number'];
        $fcmToken = $_POST['fcm_token'];
    } else {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(array('error' => 'Phone number or FCM token is missing'));
        die();
    }

    try {
        // Check if the user exists by phone number
        $stmt = $conn->prepare('SELECT * FROM users WHERE user_phone_num = :phone_number');
        $stmt->bindParam(':phone_number', $phoneNumber);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            // If the user does not exist, insert a new record
            $userID = generateRandomUserID();

            $stmt = $conn->prepare('INSERT INTO users (user_id, user_phone_num, FCM_token) VALUES (:user_id, :phone_number, :fcm_token)');
            $stmt->bindParam(':user_id', $userID);
            $stmt->bindParam(':phone_number', $phoneNumber);
            $stmt->bindParam(':fcm_token', $fcmToken);
            $stmt->execute();

            // Return a response for a new user
            header('Content-Type: application/json');
            echo json_encode(array(
                'status' => 'success',
                'message' => 'New user registered successfully',
                'user' => array(
                    'user_id' => $userID,
                    'phone_number' => $phoneNumber,
                    'fcm_token' => $fcmToken
                )
            ));
        } else {
            // If the user exists, return their information
            header('Content-Type: application/json');
            echo json_encode(array(
                'status' => 'success',
                'message' => 'User already exists',
                'user' => array(
                    'user_id' => $user['user_id'],
                    'phone_number' => $user['user_phone_num'],
                    'fcm_token' => $user['FCM_token']
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

    
    
} catch (PDOException $e) {
    // Handle database connection error
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(array('error' => 'Internal Server Error'));
    die();
}

// Handle RESTful API routing
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$endpoints = array(
    '/API/V1/login-api.php' => 'handleUserRegistrationOrLogin'
);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($endpoints[$url])) {
    $functionName = $endpoints[$url];
    $functionName($conn);
} else {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(array('error' => 'Not Found'));
}

?>
