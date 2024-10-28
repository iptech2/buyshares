<?php
session_start();
require 'config.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$sql_user = "SELECT * FROM users WHERE id = '$user_id'";
$result_user = mysqli_query($conn, $sql_user);
$user = mysqli_fetch_assoc($result_user);

// Fetch investments
$sql_investments = "SELECT * FROM investments WHERE user_id = '$user_id'";
$result_investments = mysqli_query($conn, $sql_investments);
$investments = mysqli_fetch_all($result_investments, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo $user['name']; ?></h2>
        <h3>Your Investments</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Package Amount</th>
                    <th>Investment Date</th>
                    <th>Days</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($investments as $investment): ?>
                <tr>
                    <td><?php echo $investment['amount']; ?></td>
                    <td><?php echo $investment['created_at']; ?></td>
                    <td><?php echo $investment['days']; ?></td>
                    <td><a href="withdraw.php?id=<?php echo $investment['id']; ?>" class="btn btn-danger">Withdraw</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Make a Deposit</h3>
        <form method="POST" action="deposit.php">
            <div class="form-group">
                <label>Amount</label>
                <select class="form-control" name="amount" required>
                    <option value="300">300</option>
                    <option value="550">550</option>
                    <option value="1000">1000</option>
                    <option value="3000">3000</option>
                    <option value="10000">10000</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Deposit</button>
        </form>
        
        <a href="logout.php" class="btn btn-secondary">Logout</a>
    </div>
</body>
</html>

<!-- composer config --global http-proxy http://proxy.baphin.com:4000 -->
composer config --global --unset http-proxy
composer config --global --unset https-proxy
