<?php
session_start();
require_once "../../includes/db.php";

if (!isset($_SESSION["admin"])) {
    header("Location: ../login.php");
    exit;
}

$id = $_GET["id"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $new_status = $_POST["status"];

    mysqli_query($conn, "UPDATE orders SET status='$new_status' WHERE order_id='$id'");
    header("Location: view_orders.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
        <link rel="stylesheet" href="../../style.css">

<body>

<h2>Update Order Status</h2>

<form method="POST">
    <select name="status">
        <option value="Pending">Pending</option>
        <option value="Confirmed">Confirmed</option>
        <option value="Delivered">Delivered</option>
    </select><br><br>

    <button type="submit">Save</button>
</form>

<br>
<a href="view_orders.php">Back</a>

</body>
</html>
