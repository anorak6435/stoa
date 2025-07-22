<?php
session_start();
include_once "db.php";
$sql =  "SELECT * FROM posts";

$result = mysqli_query($conn, $sql);

include "pagebuilder.php";
$pb = new PageBuilder();

// show the homepage of the blog
echo $pb->page('posts');

?>

