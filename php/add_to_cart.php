<?php
session_start();
$curr_user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
include('connection_db.php');

if ($curr_user_id) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];

        // Check if the product is already in the cart
        $existingCartItem = $conn->query("SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id");

        if ($existingCartItem->num_rows > 0) {
            // Product is already in the cart, update the quantity
            $existingRow = $existingCartItem->fetch_assoc();
            $newQuantity = $existingRow['quantity'] + $quantity;

            // Update the quantity in the cart
            $conn->query("UPDATE cart SET quantity = $newQuantity WHERE user_id = $user_id AND product_id = $product_id");
        } else {
            // Product is not in the cart, insert a new record
            $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $user_id, $product_id, $quantity);
            $stmt->execute();
            $stmt->close();
        }

        // Redirect to the cart page or wherever you want after adding to cart
        header("Location: cart.php");
        exit();
    }
}
else{
    header("Location: cart.php");
    exit();
}
