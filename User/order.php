<?php
require_once "../includes/db.php";

if (!isset($_GET['isbn'])) {
    die("No book selected for order.");
}
$isbn = $_GET['isbn'];

// جلب اسم الكتاب لعرضه في النموذج
$book_title_result = mysqli_query($conn, "SELECT title FROM books WHERE isbn='$isbn'");
$book_title = mysqli_fetch_assoc($book_title_result)['title'] ?? "Unknown Book";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // تجميع البيانات
    $name = trim($_POST['name']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);

    // التحقق البسيط
    if (empty($name) || empty($address) || empty($phone) || empty($email)) {
        $message = "<p style='color:red;'>All fields are required!</p>";
    } else {
 // إدراج الطلب في جدول orders (باستخدام Prepared Statement للحماية)
        $status = "Pending";
        // ملاحظة: لا نستخدم ISBN في جدول orders الحالي، فقط بيانات العميل والحالة.
        $stmt = mysqli_prepare($conn, "INSERT INTO orders (name, address, phone, email, status) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssss", $name, $address, $phone, $email, $status);
        
        if (mysqli_stmt_execute($stmt)) {
            $message = "<p style='color:green;'>Order placed successfully! The book: " . htmlspecialchars($book_title) . " is pending.</p>";
            // هنا يجب إضافة إعادة توجيه لمنع إرسال النموذج مرة أخرى
            // header("Location: thank_you.php"); 
        } else {
            $message = "<p style='color:red;'>Error placing order.</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Place Order</title>
</head>
<body>
<h2>Order Book: <?php echo htmlspecialchars($book_title); ?></h2>

<?php echo $message; ?>

<form method="POST">
    Name: <input type="text" name="name" required><br><br>
    Email: <input type="email" name="email" required><br><br>
    Phone: <input type="text" name="phone" required><br><br>
    Address: <br>
    <textarea name="address" rows="4" cols="50" required></textarea><br><br>

    <button type="submit">Place Order</button>
</form>

<br>
<a href="show.php?isbn=<?php echo $isbn; ?>">Back to Book Details</a>

</body>
</html>