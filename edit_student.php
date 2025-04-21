<?php
require 'db.php'; 

// Gets the student ID
$student_id = $_GET['student_id']; 

// Gets the student's current details
$sql = "SELECT 
            s.student_id, 
            s.firstname, 
            s.lastname, 
            r.room_id,
            r.room_number, 
            p.status AS payment_status, 
            p.amount AS amount_due 
        FROM students s
        LEFT JOIN rooms r ON s.room_id = r.room_id
        LEFT JOIN payments p ON s.student_id = p.student_id
        WHERE s.student_id = '$student_id'"; // Filters by the student ID
        
$result = $conn->query($sql); // executes the quey
$student = $result->fetch_assoc(); // Gets the student's details

// Form subi,ssion that updates the student's details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $roomID = $_POST['roomID'];
    $payment_status = $_POST['payment_status'];
    $amount_due = $_POST['amount_due'];

    // Update the student's details in the database
    $update_sql = "UPDATE students s
                   LEFT JOIN payments p ON s.student_id = p.student_id
                   SET s.firstname = '$firstname', 
                       s.lastname = '$lastname', 
                       s.room_id = $roomID, 
                       p.status = '$payment_status', 
                       p.amount = $amount_due
                   WHERE s.student_id = '$student_id'";
    
    // Executes update query then brings users back to the view content page 
    if ($conn->query($update_sql)) {
        header("Location: view_content.php");
        exit; 
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <!-- Header stuff -->
    <header>
        <h2>Student Residence Management</h2>
        <a href="view_content.php"><button class="button">Back</button></a>
        <a href="homepage.php"><button class="button">Home</button></a>
        <a href="logout.php"><button class="button">Log out</button></a>
    </header>

    <!-- Page content  -->
    <div class="page_container">
        <h1 class="title">Edit Student</h1>
        <div id="form_container">
            <!-- Form to edit the student's details -->
            <form method="POST" action="edit_student.php?student_id=<?php echo $student_id; ?>">
                <h3>Edit your details for Student:<br><?php echo $student_id?></h3>
                <!-- Edit first name -->
                <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($student['firstname']); ?>">

                <!-- Edit last name -->
                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($student['lastname']); ?>">

                <!-- Edit room -->
                <label for="room">Room Number:</label>
                <select id="roomID" name="roomID" required>
                    <!-- Displays current room as the default room -->
                    <option value="<?php echo $student['room_id']; ?>">Room <?php echo htmlspecialchars($student['room_number']); ?></option>
                    <!-- gets all rooms from the db -->
                    <?php
                    $result = $conn->query("SELECT room_id, room_number FROM rooms");
                    while ($row = $result->fetch_assoc()) {
                        // Markst he cyrrent room as selected
                        $selected = ($row['room_id'] == $student['room_id']) ? 'selected' : '';
                        echo "<option value='" . $row['room_id'] . "' $selected>Room " . htmlspecialchars($row['room_number']) . "</option>";
                    }
                    ?>
                </select>

                <!-- Dropdown for payment status -->
                <label for="payment_status">Payment Status:</label>
                <select id="payment_status" name="payment_status" required>
                    <option value="paid" <?php echo $student['payment_status'] === 'paid' ? 'selected' : ''; ?>>Paid</option>
                    <option value="unpaid" <?php echo $student['payment_status'] === 'unpaid' ? 'selected' : ''; ?>>Unpaid</option>
                    <option value="overdue" <?php echo $student['payment_status'] === 'overdue' ? 'selected' : ''; ?>>Overdue</option>
                </select><br>

                <!-- Input field for amount due -->
                <label for="amount_due">Amount Due (€):</label>
                <input type="number" id="amount_due" name="amount_due" step="0.01" value="<?php echo htmlspecialchars($student['amount_due']); ?>" required>
                <br><br>
                
                <!-- Submit button -->
                <button type="submit" class="button" role="button">Confirm Edits</button>
            </form>
        </div>
    </div>
</body>
</html>