<?php
require 'db.php';
// Check if the user is already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
   header("Location: homepage.php");
   exit;
}

// Handle search functionality
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

// Fetch students and their details
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

if (!empty($search)) {
    $sql .= " WHERE s.student_id LIKE '%$search%'";
}

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
        <a href="homepage.php"><button class="button" role="button">home</button></a>
        <a href="logout.php"><button class="button" role="button">log out</button></a>
    </header>

    <div class="page_container">
        <h1 class="title">Student List</h1>
        <div id="list-container">
             <!-- Search Bar -->
            <form method="GET" action="view_content.php" class="search_bar">
                <input type="text" name="search" placeholder="Search Student ID" value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit"><i class="gg-search"></i></button>
            </form>

            <!-- Student List -->
            <div class="student-list">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="student-item">
                            <div class="student-details">
                                <p><strong>Student ID:</strong> <?php echo $row['student_id']; ?></p>
                                <p><strong>Student Name:</strong> <?php echo $row['firstname']; echo ' '; echo $row ['lastname']; ?> </p>
                                <p><strong>Room Number:</strong> <?php echo $row['room_number'] ?? 'N/A'; ?></p>
                                <p><strong>Payment Status:</strong> <?php echo ucfirst($row['payment_status'] ?? 'unpaid'); ?></p>
                                <p><strong>Amount Due:</strong> €<?php echo number_format($row['amount_due'] ?? 0, 2); ?></p>
                            </div>
                            <div class="actions">
                                <a href="edit_student.php?student_id=<?php echo $row['student_id']; ?>" title="Edit">
                                    <i class="gg-pen"></i> Edit
                                </a>
                                <a href="delete_student.php?student_id=<?php echo $row['student_id']; ?>" title="Delete" onclick="return confirm('Are you sure you want to delete this student?');">
                                    <i class="gg-trash"></i> Delete
                                </a>
                            </div>
                        </div>
                        <hr> <!-- Divider -->
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No students found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>