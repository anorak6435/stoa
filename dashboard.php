<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // redirect
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Dashboard</h1>
    <p>welcome <?php echo $_SESSION["user_name"]?>, Let's get to work!</p>

    <a href='logout.php'>Logout</a>
</body>
</html>