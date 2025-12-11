<?php
require_once "../includes/db.php";

if (!isset($_GET['isbn'])) {
    die("Book not specified.");
}

$isbn = $_GET['isbn'];

// استخدام Prepared Statement لجلب الكتاب (للحماية)
$stmt = mysqli_prepare($conn, "SELECT * FROM books WHERE isbn=?");
mysqli_stmt_bind_param($stmt, "s", $isbn);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$book = mysqli_fetch_assoc($result)) {
    die("Book not found.");
}
?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="../style.css">
<head>
    <title><?php echo $book['title']; ?></title>
</head>
<body>

<a href="index.php">Back to Book List</a>
<hr>
<h2><?php echo $book['title']; ?></h2>

<img src="../images/<?php echo $book['image']; ?>" width="300" alt="<?php echo $book['title']; ?>"><br>
<br>

<strong>ISBN:</strong> <?php echo $book['isbn']; ?><br>
<strong>Year:</strong> <?php echo $book['year']; ?><br>
<br>

<h3>Description:</h3>
<p><?php echo nl2br($book['description']); ?></p>

<a href="order.php?isbn=<?php echo $book['isbn']; ?>">Order this Book</a>

</body>
</html>
