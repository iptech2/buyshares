<?php
session_start();
require 'config.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $new_password = mysqli_real_escape_string($conn, $_POST['password']);
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update password and remove reset token
        $sql = "UPDATE users SET password = '$hashed_password', reset_token = NULL WHERE reset_token = '$token'";
        
        if (mysqli_query($conn, $sql)) {
            echo "Password updated successfully. You can now log in.";
        } else {
            echo "Error updating password: " . mysqli_error($conn);
        }
    }
} else {
    echo "Invalid token.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Update Password</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label>New Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Password</button>
        </form>
    </div>
</body>
</html>
