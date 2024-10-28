<?php
session_start();
require 'config.php';
require 'mpesa.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $amount = $_POST['amount'];

    // Insert deposit record
    $sql = "INSERT INTO investments (user_id, amount, created_at, days) VALUES ('$user_id', '$amount', NOW(), '0')";
    if (mysqli_query($conn, $sql)) {
        $phoneNumber = 'YourPhoneNumber'; // Replace with user's phone number
        $response = stkPushRequest($phoneNumber, $amount);
        echo "Deposit request sent. Check your M-Pesa for confirmation.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
