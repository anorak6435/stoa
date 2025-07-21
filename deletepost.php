<?php
session_start();
$user_id = $_SESSION['user_id'];
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
} else {
    if ($_SESSION['user_role'] == "subscriber") {
        header("Location: dashboard.php");
    } else {
        $post_id = $_GET['post_id'];
        $sql = "DELETE from posts WHERE id = '$post_id'";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo "Error: {$conn->error}";
        } else {
            echo "Deleted Succesfully!";
        }
    }
}


?>