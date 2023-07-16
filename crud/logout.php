<?php

// Enable error reporting and display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
session_unset();
session_destroy();

// Check for any errors or warnings
if (error_get_last()) {
    // Log the error
    error_log(implode("\n", error_get_last()));
    
    // Display an error message to the user
    echo "An error occurred. Please try again later.";
    exit();
}

// Clear browser cache and cookies
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
setcookie("PHPSESSID", "", time() - 3600, "/");

// Redirect the user to the "index.php" page
header("Location: index.php");
exit();
