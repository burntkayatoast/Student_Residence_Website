<?php
session_start();
session_unset(); // Unsets all session variables
session_destroy(); // Destroys the session

// Redirects back to the login page
header("Location: index.php");
exit;
?>