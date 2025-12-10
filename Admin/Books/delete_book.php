<?php
session_start();
require_once "../../includes/db.php";

if (!isset($_SESSION["admin"])) {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET["delete"])) {
    $isbn = $_GET["delete"];
    mysqli_query($conn, "DELETE FROM books WHERE isbn='$isbn'");
    header("Location: delete_books.php");
}

$result = mysqli_query($conn, "SELECT * FROM books");
?>

<!DOCTYPE html>
<html>
<body>

<h2>Delete Books</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ISBN</th>
        <th>Title</th>
        <th>Action</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $row["isbn"]; ?></td>
        <td><?php echo $row["title"]; ?></td>
        <td>
            <a href="?delete=<?php echo $row['isbn']; ?>"
               onclick="return confirm('Delete this book?');">
               Delete
            </a>
        </td>
    </tr>
    <?php } ?>

</table>

<br>
<a href="../dashboard.php">Back</a>

</body>
</html>
