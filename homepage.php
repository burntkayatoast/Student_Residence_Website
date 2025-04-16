<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php"); // Redirects user to the login page if the user is logged in
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
    <!-- HEADER -->
    <header>
        <button class="button" role="button"><a href="logout.php">log out</a></button>
    </header>

    <!-- BUTTON CARDS -->
    <div class="page_container">
        <h1 class="title">CONTENT MANAGEMENT</h1>
        <div class="grid-container">
            <!-- Adding content -->
            <div class="grid-item">
                <a href="add_content.php">
                    <h2>[Add Student Residence]</h2>
                    <p>Add new content to the system.</p>
                </a>
            </div>
            <!-- Viewing content -->
            <div class="grid-item">
                <a href="view_content.php">
                    <h2>[View Student Residence]</h2>
                    <p>View existing content in the system.</p>
                </a>
            </div>
            <!-- Editing ccontent -->
            <div class="grid-item">
                <a href="edit_content.php">
                    <h2>[Edit Student Residence]</h2>
                    <p>Edit existing content in the system.</p>
                </a>
            </div>
            <!-- Deleting content -->
            <div class="grid-item">
                <a href="delete_content.php">
                    <h2>[Delete Student Residence]</h2>
                    <p>Remove content from the system.</p>
                </a>
            </div>
        </div>
    </div>
</body>
</html>

