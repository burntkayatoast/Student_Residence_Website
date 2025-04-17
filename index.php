<?php
session_start();
require 'db.php';

// Check if the user is already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
   header("Location: homepage.php");
   exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $email = $_POST['email'];
   $password = $_POST['password'];

   // Checking if the user email exists
   $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
   $stmt->bind_param("s", $email); // Binds email parameter
   $stmt->execute(); // Executes the query
   $result = $stmt->get_result(); // Gets teh result

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc(); // Gets the result

        if ($password === $user['password']) {
            // Set session variables to indicate the user is logged in
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $user['email'];

            // Redirect back to the homepage
            header("Location: homepage.php");
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or passwOrd.";
    }

   // Close connection
   $stmt->close();
   $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>
   <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
   <div id="login_container">
        <form method="POST" action="index.php">
            <h1>LOGIN</h1>
            <br>
            <!-- Input field for email -->
            <input type="text" id="email" name="email" placeholder="email" required>
            <br>
            <!-- Input field for password -->
            <input type="password" id="password" name="password" placeholder="password" required>
            <br>
            <!-- Error message if there's an error with input fields -->
            <?php if (isset($error)): ?>
            <p style="color: red; font-size: 14px;"><?php echo $error; ?></p>
            <?php endif; ?>
            <br>
            <button type="submit" class="button">Login</button>
        </form>
   </div>
</body>
</html>