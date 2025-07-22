<?php
$response = file_get_contents('http://localhost/wordpress/wp-json/wp/v2/posts?_fields=title,content');
$post_list = json_decode($response, true);

foreach($post_list as $post) {
    echo "<h1>" . $post["title"]["rendered"] . "</h1><div>" . $post["content"]["rendered"] . "</div>";
}

$myArray = array('hello', 'world');
echo implode(' ', $myArray); // Output: hello world

?>