<?php
$wordpress_json_link = "http://localhost/wordpress/wp-json";
$response = file_get_contents($wordpress_json_link . '/wp/v2/posts?_fields=id,title,content');
$post_list = json_decode($response, true);

echo "<h1>POSTS:</h1>";

foreach($post_list as $post) {
    // get the comments that are part of the post
    $response = file_get_contents($wordpress_json_link . '/wp/v2/comments?post=' . $post["id"]);
    $comment_list = json_decode($response, true);
    
    $comment_html = "";
    foreach($comment_list as $comment) {
        $comment_html = $comment_html . "<p>" . $comment["content"]['rendered'] . "</p>";
    }

    echo "<h2>" . $post["title"]["rendered"] . "</h2><div>" . $post["content"]["rendered"] . "<div><h3>comments:</h3>" . $comment_html . "</div>" .  "</div>";
}


// get the users that wordpress knows about.
$response = file_get_contents($wordpress_json_link . '/wp/v2/users');
$user_list = json_decode($response, true);

foreach($user_list as $user) {
    echo "<div><h2>" . $user["name"] ."</h2></div>";
}

?>