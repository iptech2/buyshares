<?php
session_start();
require 'config.php';

if (isset($_GET['token']) && isset($_GET['user_id'])) {
    $token = $_GET['token'];
    $user_id = $_GET['user_id'];

    // Verify token and update user record
    $sql = "UPDATE users SET verified = 1 WHERE id = '$user_id'";
    
    if (mysqli_query($conn, $sql)) {
        echo "Email verified successfully! You can now log in.";
    } else {
        echo "Error verifying email: " . mysqli_error($conn);
    }
} else {
    echo "Invalid verification link.";
}
?>
