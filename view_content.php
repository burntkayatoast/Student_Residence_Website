<?php
require 'db.php';
// Check if the user is already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
   header("Location: homepage.php");
   exit;
}

// Handles search functionality
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

// Gets students and their details
$sql = "SELECT 
            s.student_id AS student_id, 
            s.firstname, 
            s.lastname, 
            r.room_number, 
            p.status AS payment_status, 
            p.amount AS amount_due 
        FROM students s
        LEFT JOIN rooms r ON s.room_id = r.room_id
        LEFT JOIN payments p ON s.student_id = p.student_id";

// adds a WHERE clause to filter the results
if (!empty($search)) {
    $sql .= " WHERE s.student_id LIKE '%$search%'";
}
$sql .= " ORDER BY r.room_number ASC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Content</title>
    <link rel="stylesheet" href="stylesheet.css">
    <link href="https://cdn.jsdelivr.net/npm/css.gg/icons/all.css" rel="stylesheet"> <!-- CSS.gg Icons -->
</head>
<body>
    <!-- HEADER -->
    <header>
        <h2>Student Residence Management</h2>
        <a href="homepage.php"><button class="button" role="button">home</button></a>
        <a href="logout.php"><button class="button" role="button">log out</button></a>
    </header>

    <div class="page_container">
        <h1 class="title">Student List</h1>
        <div id="list-container">
             <!-- Search Bar -->
            <form method="GET" action="view_content.php" class="search_bar">
                <!-- Input field for search -->
                <input type="text" name="search" placeholder="Search Student ID" value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit"><i class="gg-search"></i></button>
            </form>

            <!-- Student List -->
            <div id="actual-list">
            <div class="student-list">
                <!-- Loops through the results and displays each student in the DB -->
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="student-item">
                            <!-- Displays the deets -->
                            <div class="student-details">
                                <p><strong>Student ID:</strong> <?php echo $row['student_id']; ?></p>
                                <p><strong>Student Name:</strong> <?php echo $row['firstname']; echo ' '; echo $row ['lastname']; ?> </p>
                                <p><strong>Room Number:</strong> <?php echo $row['room_number'] ?? 'N/A'; ?></p>
                                <p><strong>Payment Status:</strong> <?php echo ucfirst($row['payment_status'] ?? 'unpaid'); ?></p>
                                <p><strong>Amount Due:</strong> €<?php echo number_format($row['amount_due'] ?? 0, 2); ?></p>
                            </div>
                            <div class="actions">
                                <!-- Edit button -->
                                <a href="edit_student.php?student_id=<?php echo $row['student_id']; ?>" title="Edit">
                                    <i class="gg-pen"></i> Edit
                                </a>
                                <!-- Delete button -->
                                <a href="delete_student.php?student_id=<?php echo $row['student_id']; ?>" title="Delete" onclick="return confirm('Are you sure you want to delete this student?');">
                                    <i class="gg-trash"></i> Delete
                                </a>
                            </div>
                        </div>
                        <hr> <!-- Divider -->
                    <?php endwhile; ?>
                <?php else: ?>
                    <!-- Display message if there are no students i nteh DB -->
                    <p>No students found.</p>
                <?php endif; ?>
            </div>
            </div>
        </div>
    </div>
</body>
</html>