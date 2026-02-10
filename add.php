<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $qty = $_POST['qty'];
    $price = $_POST['price'];

    $sql = "INSERT INTO items (name, qty, price) VALUES ('$name', '$qty', '$price')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>