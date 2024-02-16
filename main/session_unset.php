<?php
// Start the session
session_start();

// Remove all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to a page after clearing session
header("Location: index.php"); // Change index.php to the desired page

// Make sure to exit after header redirect to prevent further execution
exit();
?>
