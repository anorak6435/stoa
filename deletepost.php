<?php
session_start();
$user_id = $_SESSION['user_id'];
include "db.php";

$post_id = $_GET['post_id'];
$sql = "DELETE from posts WHERE id = '$post_id'";
$result = mysqli_query($conn, $sql);
if (!$result) {
    echo "Error: {$conn->error}";
} else {
    echo "Deleted Succesfully!";
}

?>