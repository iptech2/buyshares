<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // Generate reset token and send email
        $token = bin2hex(random_bytes(50));
        $sql_update = "UPDATE users SET reset_token = '$token' WHERE id = '".$user['id']."'";
        mysqli_query($conn, $sql_update);
        
        $to = $email;
        $subject = "Password Reset Request";
        $message = "Click the link to reset your password: http://yourdomain.com/update_password.php?token=$token";
        $headers = "From: no-reply@yourdomain.com";

        mail($to, $subject, $message, $headers);
        echo "Check your email for a link to reset your password.";
    } else {
        echo "Email not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Reset Password</button>
        </form>
    </div>
</body>
</html>
