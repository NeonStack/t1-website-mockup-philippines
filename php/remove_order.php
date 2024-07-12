<?php
session_start();
include('connection_db.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $sql = "DELETE FROM orders WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();
    header("Location: orders.php?category=All%20Orders");
    exit();
}else {
    echo "We couldn't find the page you were looking for!";
}
?>