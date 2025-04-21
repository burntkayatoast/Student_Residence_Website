<?php 
$servername = 'localhost';
$dbname = 'student_residence_DB';
$username = 'root';
$password = '';

// Creates connection to the db
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>