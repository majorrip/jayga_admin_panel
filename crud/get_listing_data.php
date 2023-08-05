<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jayga_db_1";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the database connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['listing_id']) && !empty($_GET['listing_id'])) {
    $listing_id = $_GET['listing_id'];

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("SELECT * FROM listing WHERE listing_id = ?");
    $stmt->bind_param("i", $listing_id);
    $stmt->execute();

    // Fetch the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Create an array to store the data
        $listing_data = array(
            'lister_id' => $row['lister_id'],
            'lister_name' => $row['lister_name'],
            'guest_number' => $row['guest_number'],
            'bedroom_number' => $row['bedroom_number'],
            'bathroom_number' => $row['bathroom_number'],
            'listing_title' => $row['listing_title'],
            'description' => $row['description'],
            'price' => $row['price'],
            'address' => $row['listing_address'],
            'zip_code' => $row['zip_code'],
            'district' => $row['district'],
            'town' => $row['town'],
            'allow_short_stay' => $row['allow_short_stay']
            // Add other fields here
        );

        // Close the prepared statement
        $stmt->close();

        // Convert the array to JSON format and send the response
        header('Content-Type: application/json');
        echo json_encode($listing_data);
    } else {
        // Listing not found
        echo "Listing not found";
    }
} else {
    // Invalid or missing listing_id parameter
    echo "Invalid or missing listing_id parameter";
}

// Close the database connection
$conn->close();
?>
