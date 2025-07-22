<?php
session_start();

include_once "db.php";

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
            
            header("Location: index.php"); // redirect
        }
    }
}

include "pagebuilder.php";
$pb = new PageBuilder();

echo $pb->page('login');


?>