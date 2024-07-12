<?php
include('connection_db.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['cart_id'])) {
    $cart_id = $_GET['cart_id'];

    $sql = "DELETE FROM cart WHERE cart_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cart_id);
    $stmt->execute();
    $stmt->close();

    header("Location: cart.php");
    exit();
} else {
    echo "Invalid request!";
}
?>
