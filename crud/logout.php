<?php
session_start(); // Start or resume the current session


// Clear all session variables
$_SESSION = array();

// Destroy the session
session_unset();
session_destroy();

// Redirect the user to the login page or any desired page
header("Location: ../index.php");
exit();
?>
