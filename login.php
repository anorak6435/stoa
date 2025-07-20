<?php
session_start();
include "db.php";

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $password = hash('sha256', $_POST['psw']);
    
    $sql = "SELECT * FROM users WHERE name = '$name'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error: {$conn->error}";
    } else {
        if ($result->num_rows>0) {
            $row = mysqli_fetch_assoc($result);

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_role'] = $row['role'];
            
            echo "Logged in successfully! <a href= 'dashboard.php'>Dashboard</a>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="login.php" method="POST">
        <div class="container">
            <h1>Login</h1>
            <p>Get back to posting.</p>
            <hr>

            <label for="name"><b>Name</b></label>
            <input type="text" placeholder="Enter name" name="name" id="name" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw" id="psw" required>
            <hr>

            <button type="submit" name="submit" class="loginbtn">Login</button>
            </div>

            <div class="container signin">
            <p>No account yet? <a href="register.php">Register here</a>.</p>
        </div>
    </form>
</body>
</html>