<?php 
require 'db.php';

// Check if the user is already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
   header("Location: homepage.php");
   exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Gets info from the input fields
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $studentID = $_POST['studentID'];
    $roomID = $_POST['roomID'];
    $paymentStatus = $_POST['paymentStatus'];
    $amountDue = $_POST['amountDue'];

    // Insert student details into the students table
    $sql_students = "INSERT INTO students (student_id, firstname, lastname, room_id) VALUES ('$studentID', '$firstname', '$lastname', $roomID)";
    if ($conn->query($sql_students) === true) {
        // Insert payment details into the payments table if student deets are successful
        $sql_payments = "INSERT INTO payments (student_id, amount, status) VALUES ('$studentID', $amountDue, '$paymentStatus')";
        if ($conn->query($sql_payments) === true) {
            // If successful, redirects to add_contnt
            header("Location: add_content.php");
            exit;
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student Residence</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <!-- HEADER -->
    <header>
        <!-- Home button -->
        <a href="homepage.php"><button class="button" role="button">home</button></a>
        <!-- Logout button -->
        <a href="logout.php"><button class="button" role="button">log out</button></a>
    </header>

    <!-- FORM for Student residence detail -->
    <div class="page_container">
    <h1 class="title">Resident Details</h1>
    <div id="form_container">
        <form method="POST" action="add_content.php">
        <h3>STUDENT DETAILS</h3>
            <!-- Input field for residence first name -->
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" required><br><br>

            <!-- Input field for residence surname -->
            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" required><br><br>

            <!-- Input field for student ID -->
            <label for="studentID">Student ID:</label>
            <input type="text" id="studentID" name="studentID" required><br><br>

            <!-- Dropdown for room selection -->
            <label for="roomID">Room:</label>
            <select id="roomID" name="roomID" required>
                <option value="">-- Select Room --</option>
                <?php
                // Gets the rooms that are available from the database
                $result = $conn->query("SELECT room_id, room_number FROM rooms WHERE room_id NOT IN (SELECT room_id FROM students WHERE room_id IS NOT NULL)");
                while ($row = $result->fetch_assoc()) {
                    // Available rooms are displayed
                    echo "<option value='" . $row['room_id'] . "'>Room " . $row['room_number'] . "</option>";
                }
                ?>
            </select><br><br>

            <!-- Payment Status -->
            <label for="paymentStatus">Payment Status:</label>
            <select id="paymentStatus" name="paymentStatus" required>
                <option value="">-- Select Payment Status --</option>
                <option value="paid">Paid</option>
                <option value="unpaid">Unpaid</option>
                <option value="overdue">Overdue</option>
            </select><br><br>

            <!-- Amount Due -->
            <label for="amountDue">Amount Due (€):</label>
            <input type="number" id="amountDue" name="amountDue" step="1.00" required><br><br>

            <!-- Submit button -->
            <button type="submit" class="button">Next: Payment Details</button>
        </form>
    </div>
    </div>
</body>
</html>