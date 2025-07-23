<?php
$server = "localhost";
$user = "root";
$pass = "";
$dbname = "stoa";

$conn = new mysqli($server, $user, $pass, $dbname);
if (!$conn) {
    echo "Connection Error: {$conn->connect_error}";
}

function query($sql) {
    global $conn;
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "Failed on: {$conn->error}";
    }
    return $result;
}
// There is mysql and the wordpress api.

// ---------                       -------------
// | mysql |                       | wordpress |
// ---------                       -------------
//    ^                                 ^
//    |      -------------------        |
//    +------| StoaDataManager |--------+
//           -------------------

// for mysql is there the StoaSqlHandler
// for wordpress there is the StoaWordpressHandler

interface DataHandler {
    function load_categories();
    function load_posts();
}

class StoaSqlHandler implements DataHandler {
    function load_categories() {
        $result = query("SELECT * FROM categories");
        $categories = array();
         while ($row = mysqli_fetch_assoc($result)) {
            array_push($categories, $row);
        }
        return $categories;
    }
    function load_posts() {
        $result = query("SELECT * FROM posts");
        $posts = array();
        while ($post = mysqli_fetch_assoc($result)) {
            array_push($posts, $post);
        }
        return $posts;
    }
}

class StoaWordpressHandler implements DataHandler {
    private $wp_json_link = "http://localhost/wordpress/wp-json";
    function __construct() {

    }

    function load_posts() {
        $response = file_get_contents($this->wp_json_link . '/wp/v2/posts?_fields=id,title,content');
        $wp_post_list = json_decode($response, true);
        // cast the posts into a better object.

        $posts = array();
        foreach ($wp_post_list as $wp_post) {
            array_push($posts, ["id" => $wp_post["id"], "title" => $wp_post["title"]["rendered"], "content" => $wp_post["content"]["rendered"]]);
            
        }

        return $posts;
    }

    function load_categories() {
        $response = file_get_contents($this->wp_json_link . "/wp/v2/categories");
        return json_decode($response, true);
    }

}

?>