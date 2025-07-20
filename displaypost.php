<?php
session_start();
include "db.php";
$sql =  "SELECT * FROM posts";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<h2>{$row['title']}</h2>";
    echo "<div>{$row['content']}</div>";
    echo "<img src='images/{$row['image']}'/><br>";
    echo "<a href='updatepost.php?post_id={$row['id']}'>update</a><a href='deletepost.php?post_id={$row['id']}'>delete</a><hr>";
}

?>