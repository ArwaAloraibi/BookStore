<?php
session_start();
require_once "../includes/db.php";

$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    // Validation
    if (empty($username) || empty($password) || empty($confirm_password)) {
        $message = "All fields are required!";
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match!";
    } else {
        // Check if username already exists
        $stmt = mysqli_prepare($conn, "SELECT * FROM admin WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_fetch_assoc($result)) {
            $message = "Username already exists!";
        } else {
            // Hash the password
            $hashed_password = hash("sha256", $password);

            // Insert new admin
            $stmt = mysqli_prepare($conn, "INSERT INTO admin (username, password) VALUES (?, ?)");
            mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);

            if (mysqli_stmt_execute($stmt)) {
                $message = "Admin account created successfully!";
            } else {
                $message = "Error creating account.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Signup</title>
</head>
<body>
<h2>Admin Signup</h2>

<p style="color:green;"><?php echo $message; ?></p>

<form method="POST">
    Username:<br>
    <input type="text" name="username" required><br><br>

    Password:<br>
    <input type="password" name="password" required><br><br>

    Confirm Password:<br>
    <input type="password" name="confirm_password" required><br><br>

    <button type="submit">Sign Up</button>
</form>

<br>
<a href="signin.php">Already have an account? Sign in</a>
</body>
</html>

