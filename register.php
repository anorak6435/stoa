<?php
    session_start();

    if (isset($_POST["submit"])) {
        $name = $_POST["name"];
        $password = hash('sha256', $_POST["psw"]);
        $role = $_POST["role"];

        include_once "db.php";

        $sql = "INSERT INTO users (name, password, role) VALUES ('$name', '$password', '$role')";

        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo "Failed on: {$conn->error}";
        } else {
            echo "Succesfully Registered!";
        }
    }

    include "pagebuilder.php";
    $pb = new PageBuilder();
    
    echo $pb->page('register');
?>
 