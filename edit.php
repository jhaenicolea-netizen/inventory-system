<?php
include 'db.php';
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM items WHERE id=$id");
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $qty = $_POST['qty'];
    $price = $_POST['price'];

    $conn->query("UPDATE items SET name='$name', qty='$qty', price='$price' WHERE id=$id");
    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h3>Edit Item</h3>
    <form method="POST" class="w-50">
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="<?= $row['name'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Quantity</label>
            <input type="number" name="qty" class="form-control" value="<?= $row['qty'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Price</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?= $row['price'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
</body>
</html>