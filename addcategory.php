<?php
session_start();

include "db.php";

if (!isset($_SESSION["user_id"])) {
    echo "You are not an Administrator";
    header("Location: login.php"); // redirect
} else {
    if ($_SESSION['user_role'] == "admin") {
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $sql = "INSERT INTO categories (name) VALUES ('$name')";
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                echo "Error: {$conn->error}";
            } else {
                echo "Category added succesfully!";
            }
        }
    } else {
        header("Location: index.php"); // redirect
        
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
</head>
<body>
    <form action="addcategory.php" method="POST">
        <input type="text" name="name">
        <input type="submit" name="submit" value="Add category">
        <a href='index.php'>Index</a>
    </form>
</body>
</html>