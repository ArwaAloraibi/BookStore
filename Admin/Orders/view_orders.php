<?php
session_start();
require_once "../../includes/db.php";

if (!isset($_SESSION["admin"])) {
    header("Location: ../login.php");
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM orders ORDER BY order_id DESC");
?>

<!DOCTYPE html>
<html>
        <link rel="stylesheet" href="../../style.css">

<body>

<h2>All Orders</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $row["order_id"]; ?></td>
        <td><?php echo $row["name"]; ?></td>
        <td><?php echo $row["phone"]; ?></td>
        <td><?php echo $row["status"]; ?></td>
        <td><a href="update_status.php?id=<?php echo $row['order_id']; ?>">Update</a></td>
    </tr>
    <?php } ?>

</table>

<br>
<a href="../dashboard.php">Back</a>

</body>
</html>
