<?php
require 'db.php';

// checks if student_id is provided so script runs if a valid id is passed
if (isset($_GET['student_id'])) {
    $student_id = $conn->real_escape_string($_GET['student_id']);

    // Delete the student with the specified id from the database
    $sql = "DELETE FROM students WHERE student_id = '$student_id'";
    if ($conn->query($sql) === true) {
        // Redirects back to view_content.php 
        header("Location: view_content.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

?>