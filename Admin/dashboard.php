<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<body>
<h2>Admin Dashboard</h2>

<p>Welcome, <?php echo $_SESSION["admin"]; ?></p>

<a href="Books/add_book.php">Add Book</a><br>
<a href="Books/edit_book.php">Edit Books</a><br>
<a href="Books/delete_book.php">Delete Books</a><br>
<a href="Orders/view_orders.php">View Orders</a><br>
<a href="logout.php">Logout</a>

</body>
</html>
