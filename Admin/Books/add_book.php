<?php
session_start();
require_once "../../includes/db.php";

if (!isset($_SESSION["admin"])) {
    header("Location: ../login.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $isbn = trim($_POST["isbn"]);
    $title = trim($_POST["title"]);
    $year = trim($_POST["year"]);
    $description = trim($_POST["description"]);

    if (empty($isbn) || empty($title) || empty($year) || empty($description)) {
        $message = "All fields are required!";
    } 
    else if (!isset($_FILES["image"]) || $_FILES["image"]["error"] !== 0) {
        $message = "Image upload failed!";
    }
    else {

        $targetDir = "../../images/";
        $image = $isbn . ".jpg";   
        $targetFile = $targetDir . $image;

        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $message = "Error uploading image file!";
        } else {

            $sql = "INSERT INTO books (isbn, title, year, image, description)
                    VALUES ('$isbn', '$title', '$year', '$image', '$description')";

            if (mysqli_query($conn, $sql)) {
                $message = "Book added successfully!";
            } else {
                $message = "Error: ISBN already exists!";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="../../style.css">

<body>

<h2>Add Book</h2>

<p style="color:green;"><?php echo $message; ?></p>

<form method="POST" enctype="multipart/form-data">
    ISBN: <input type="text" name="isbn" required><br><br>
    Title: <input type="text" name="title" required><br><br>
    Year: <input type="number" name="year" required><br><br>

    Image: <input type="file" name="image" accept="image/*" required><br><br>

    Description:<br>
    <textarea name="description" rows="4" cols="40" required></textarea><br><br>

    <button type="submit">Add Book</button>
</form>

<br>
<a href="../dashboard.php">Back</a>

</body>
</html>
