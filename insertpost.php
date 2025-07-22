<?php
session_start();
$user_id = $_SESSION['user_id'];
include_once "db.php";
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
} else {
    if ($_SESSION['user_role'] == 'author') {
        $sql = "SELECT * FROM categories";

        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo "Failed on: {$conn->error}";
        } else {
            if (isset($_POST['submit'])) {
                $title = $_POST['title'];
                $content = $_POST['content'];
                $category = $_POST['category'];
                $image_name = $_FILES['image']['name'];
                $temp_location = $_FILES['image']['tmp_name'];
                $our_location = "images/";
                if (!empty($image_name)) {
                    move_uploaded_file($temp_location, $our_location.$image_name);
                }

                $sql_cat = "SELECT (id) FROM categories WHERE name = '$category'";

                $result_cat = mysqli_query($conn, $sql_cat);
                if ($result_cat->num_rows > 0) {
                    $row = mysqli_fetch_assoc($result_cat);
                    $category_id = $row['id'];
                }

                $sql = "INSERT INTO posts (title, content, author_id, category_id, image) VALUES ('$title', '$content', '$user_id', '$category_id', '$image_name')";

                $result_post = mysqli_query($conn, $sql);

                if ($result_post) {
                    echo "Saved your post!";
                }
            }
        }
    } else {
        header("Location: index.php");
    }
}

include "pagebuilder.php";
$pb = new PageBuilder();

echo $pb->page('insertpost');

?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="insertpost.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Add your Post title" required>
        <textarea name="content" placeholder="Add your Post content here" required></textarea>
        <select name="category" id="category">
        <?php
        while ($row = mysqli_fetch_assoc($result)) { ?>
            <option value="<?php echo "{$row['name']}" ?>"><?php echo "{$row['name']}" ?></option>
        <?php } ?>
        </select>
        <input type="file" name="image">
        <input type="submit" name="submit" value="Add Post">
    </form>
</body>
</html> -->