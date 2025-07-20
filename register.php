<?php
    if (isset($_POST["submit"])) {
        $name = $_POST["name"];
        $password = hash('sha256', $_POST["psw"]);
        $role = $_POST["role"];

        include "db.php";
        session_start();

        $sql = "INSERT INTO users (name, password, role) VALUES ('$name', '$password', '$role')";

        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo "Failed on: {$conn->error}";
        } else {
            echo "Succesfully Registered!";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register Thinker</title>
</head>
<body>
    
    <form action="register.php" method="POST">
        <div class="container">
            <h1>Register</h1>
            <p>Please fill in this form to create an account.</p>
            <hr>

            <label for="name"><b>Name</b></label>
            <input type="text" placeholder="Enter name" name="name" id="name" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

            <select name="role">
                <option value="subscriber">Subscriber</option>
                <option value="author">Author</option>
            </select>
            <hr>

            <button type="submit" name="submit" class="registerbtn">Register</button>
            </div>

            <div class="container signin">
            <p>Already have an account? <a href="login.php">Sign in</a>.</p>
        </div>
    </form> 
</body>
</html>
 