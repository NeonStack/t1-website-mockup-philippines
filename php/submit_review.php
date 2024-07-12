<?php
session_start();
$curr_user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
include('connection_db.php');
if (!$curr_user_id) {
    header("Location: signin.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $curr_user_id;
    $product_id = $_POST['product_id'];
    $order_id = $_POST['order_id'];
    $comment_text = $_POST['comment_text'];
    $rating = $_POST['rate'];
    date_default_timezone_set('Asia/Manila');
    $created_at = time();
    $created_at_modified = date('Y-m-d H:i:s', $created_at);

    $stmt = $conn->prepare("INSERT INTO reviews (user_id, product_id, order_id, review_text, rating, created_at) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiisis", $user_id, $product_id, $order_id, $comment_text, $rating, $created_at_modified);
    $stmt->execute();
    $stmt->close();

    // Update isRated ..........ayusin bukas
    $stmtUpdate = $conn->prepare("UPDATE orders SET isRated = 1 WHERE order_id = ?");
    $stmtUpdate->bind_param("i", $order_id);
    $stmtUpdate->execute();
    $stmtUpdate->close();

    $conn->close();

    header("Location: product.php?id=$product_id#ratings-reviews-title");
    exit();
} else {
    header("Location: orders.php");
    exit();
}
