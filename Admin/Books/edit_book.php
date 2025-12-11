<?php
session_start();
require_once "../../includes/db.php";

if (!isset($_SESSION["admin"])) {
    header("Location: ../login.php");
    exit;
}

$message = "";
$editing = false; // to know if we are in edit mode


if (isset($_GET["edit"])) {
    $editing = true;
    $isbn = $_GET["edit"];

    $result = mysqli_query($conn, "SELECT * FROM books WHERE isbn='$isbn'");
    $book = mysqli_fetch_assoc($result);
}


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update"])) {
    $isbn = $_POST["isbn"];
    $title = $_POST["title"];
    $year = $_POST["year"];
    $description = $_POST["description"];

    $sql = "UPDATE books SET 
            title='$title',
            year='$year',
            description='$description'
            WHERE isbn='$isbn'";

    if (mysqli_query($conn, $sql)) {
        $message = "Book updated successfully!";
        $editing = false; // go back to list
    } else {
        $message = "Error updating book.";
    }
}

$books = mysqli_query($conn, "SELECT * FROM books ORDER BY year DESC");
?>
<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="../../style.css">

<body>

<h2>Edit Books</h2>

<p style="color:green;"><?php echo $message; ?></p>

<?php if ($editing === false): ?>


<table border="1" cellpadding="10">
    <tr>
        <th>ISBN</th>
        <th>Title</th>
        <th>Year</th>
        <th>Description</th>
        <th>Action</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($books)) { ?>
    <tr>
        <td><?php echo $row["isbn"]; ?></td>
        <td><?php echo $row["title"]; ?></td>
        <td><?php echo $row["year"]; ?></td>
        <td><?php echo substr($row["description"], 0, 60) . "..."; ?></td>
        <td>
            <a href="edit_book.php?edit=<?php echo $row['isbn']; ?>">Edit</a>
        </td>
    </tr>
    <?php } ?>

</table>

<br>
<a href="../dashboard.php">Back</a>

<?php else: ?>


<h3>Editing Book: <?php echo $book['isbn']; ?></h3>

<form method="POST">
    <input type="hidden" name="isbn" value="<?php echo $book['isbn']; ?>">

    Title: <br>
    <input type="text" name="title" value="<?php echo $book['title']; ?>" required><br><br>

    Year: <br>
    <input type="number" name="year" value="<?php echo $book['year']; ?>" required><br><br>

    Description:<br>
    <textarea name="description" rows="4" cols="50" required><?php echo $book['description']; ?></textarea><br><br>

    <button type="submit" name="update">Update</button>
</form>

<br>
<a href="edit_book.php">Cancel</a>

<?php endif; ?>

</body>
</html>
