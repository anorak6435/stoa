<?php
session_start();
include "db.php";
$sql =  "SELECT * FROM posts";

$result = mysqli_query($conn, $sql);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <title>Posts</title>
</head>
<body>
    <h1>Posts</h1>
    <hr>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
    ?>
    <div class="container">
    <h2><?php echo"{$row['title']}"; ?></h2>
    <div><?php echo"{$row['content']}"; ?></div>
    <img src='images/<?php echo"{$row['image']}"; ?>'/><br>
    <a href='updatepost.php?post_id=<?php echo "{$row['id']}"; ?>'>update</a><a href='deletepost.php?post_id=<?php echo "{$row['id']}"; ?>'>delete</a><hr>
    </div>
    <?php } ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>