<?php
// Database connection parameters
$host = 'podma-bd-cp1';
$username = 'jaygabdc_atif_admin';
$password = 'jaygabd_atif_123';
$dbname = 'jaygabdc_jayga_db_1';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if a POST request with user_id data is received
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];

        // Prepare and execute a SQL query to fetch reviews
        $query = "SELECT * FROM review WHERE user_id = :user_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the results as an associative array
        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return the reviews as JSON
        header('Content-Type: application/json');
        echo json_encode($reviews);
    } else {
        // If user_id parameter is not provided in the POST data, return an error message
        http_response_code(400); // Bad Request
        echo json_encode(array("message" => "user_id parameter is required in POST data"));
    }
} catch (PDOException $e) {
    // Handle database connection or query errors
    http_response_code(500); // Internal Server Error
    echo json_encode(array("message" => "Database error: " . $e->getMessage()));
}
?>
