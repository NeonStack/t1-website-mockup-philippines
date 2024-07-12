<?php
session_start();
$curr_user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
include('connection_db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    date_default_timezone_set('Asia/Manila');
    $user_id = $curr_user_id;
    $expected_delivery_date = date('Y-m-d', strtotime('+2 weeks'));

    // Retrieve user-specific information from user_info table
    $user_info_sql = "SELECT first_name, last_name, middle_name, city, postal_code, barangay, street, cell_number, email_address FROM user_info WHERE id = ?";
    $user_info_stmt = $conn->prepare($user_info_sql);
    $user_info_stmt->bind_param("i", $user_id);
    $user_info_stmt->execute();
    $user_info_result = $user_info_stmt->get_result();

    if ($user_info_row = $user_info_result->fetch_assoc()) {
        $first_name = $user_info_row['first_name'];
        $middle_name = $user_info_row['middle_name'];
        $last_name = $user_info_row['last_name'];
        $user_city = $user_info_row['city'];
        $user_postal_code = $user_info_row['postal_code'];
        $user_barangay = $user_info_row['barangay'];
        $user_street = $user_info_row['street'];
        $user_cell_number = $user_info_row['cell_number'];
        $user_email_address = $user_info_row['email_address'];
    } else {
        // Handle the case where user information is not found
        echo "User information not found!";
        exit();
    }

    // Retrieve cart information from the cart table
    $cart_sql = "SELECT cart.cart_id, cart.product_id, cart.quantity, product_list.product_price, product_list.product_name, product_list.product_image
                 FROM cart
                 INNER JOIN product_list ON cart.product_id = product_list.product_id
                 WHERE cart.user_id = ?";
    $cart_stmt = $conn->prepare($cart_sql);
    $cart_stmt->bind_param("i", $user_id);
    $cart_stmt->execute();
    $cart_result = $cart_stmt->get_result();

    while ($row = $cart_result->fetch_assoc()) {
        $product_id = $row['product_id'];
        $quantity = $row['quantity'];
        $total_price = $row['product_price'] * $quantity;
        $order_date = date('Y-m-d H:i:s');
        $isRemovable = 1;
        $product_name = $row['product_name'];
        $product_image = $row['product_image'];

        $insert_sql = "INSERT INTO orders (user_id, product_id, product_image, product_name, first_name, middle_name, last_name, order_date, quantity, total_price, user_city, user_postal_code, user_barangay, user_street, user_cell_number, user_email_address, expected_delivery_date, isRemovable)
               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("iissssssiisisssssi", $user_id, $product_id, $product_image, $product_name, $first_name, $middle_name, $last_name, $order_date, $quantity, $total_price, $user_city, $user_postal_code, $user_barangay, $user_street, $user_cell_number, $user_email_address, $expected_delivery_date, $isRemovable);
        $insert_stmt->execute();
        $insert_stmt->close();
    }

    // Clear the cart for the user
    $clear_cart_sql = "DELETE FROM cart WHERE user_id = ?";
    $clear_cart_stmt = $conn->prepare($clear_cart_sql);
    $clear_cart_stmt->bind_param("i", $user_id);
    $clear_cart_stmt->execute();
    $clear_cart_stmt->close();

    // redirect sa orders
    header("Location: orders.php?category=All%20Orders");
    exit();
} else {
    echo "Invalid request!";
}
