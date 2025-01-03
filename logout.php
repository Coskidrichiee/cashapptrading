<?php
// Start the session
session_start();

// Destroy all session variables
session_unset();

// Destroy the session itself
session_destroy();

// Redirect to the homepage or login page after logging out
header("Location: index.html");
exit();
?>
