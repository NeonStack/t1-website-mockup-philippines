<?php
include('connection_db.php');
session_start();
$curr_user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Use the correct variable name for the prepared statement
    $getEmailstmt = $conn->prepare("SELECT email_address FROM user_info WHERE id = ?");
    
    if ($getEmailstmt) {
        // Use the correct variable name for the binding
        $getEmailstmt->bind_param('i', $curr_user_id);
        
        // Execute the statement
        $getEmailstmt->execute();

        // Get the result
        $result = $getEmailstmt->get_result();

        // Fetch the email address
        $row = $result->fetch_assoc();
        $email_address = $row['email_address'];

        // Store the email address in the session
        $_SESSION['user_email'] = $email_address;
        $_SESSION['FromProfileResetPassword'] = true;
        // Close the statement after execution
        $getEmailstmt->close();
        header('Location: forgot-password.php');
        exit();
    } else {
        // Handle prepare error
        echo "<p class='error-msg-cont'>Prepare error: " . $conn->error . "</p>";
    }
}
?>
