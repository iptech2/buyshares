<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $investment_id = $_POST['investment_id'];

    // Process withdrawal logic here
    $sql = "DELETE FROM investments WHERE id = '$investment_id'";
    if (mysqli_query($conn, $sql)) {
        echo "Withdrawal processed successfully.";
    } else {
        echo "Error processing withdrawal: " . mysqli_error($conn);
    }
} else {
    $investment_id = $_GET['id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Withdraw Investment</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Confirm Withdrawal</h2>
        <form method="POST" action="">
            <input type="hidden" name="investment_id" value="<?php echo $investment_id; ?>">
            <p>Are you sure you want to withdraw this investment?</p>
            <button type="submit" class="btn btn-danger">Withdraw</button>
        </form>
    </div>
</body>
</html>
