<?php
require_once "../includes/db.php";

// جلب جميع الكتب
$result = mysqli_query($conn, "SELECT * FROM books ORDER BY year DESC");
?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="../style.css">
<head>
    <title>Book Store</title>
</head>
<body>
<h2 class="back">Book List</h2>

<div class="book-list">
<?php while ($book = mysqli_fetch_assoc($result)) { ?>
    <div class="book-item">
        <img src="../images/<?php echo $book['image']; ?>" width="150" alt="<?php echo $book['title']; ?>">
        <div>
            <strong><?php echo $book['title']; ?></strong> (<?php echo $book['year']; ?>)<br><br>
            <a href="show.php?isbn=<?php echo $book['isbn']; ?>">View Details</a>
        </div>
    </div>
<?php } ?>
</div>

</body>
</html>



