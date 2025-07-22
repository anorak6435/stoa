<?php
include_once "db.php";


class PageBuilder {
    function __construct() {

    }

    function head_styling() {
        return file_get_contents("page_parts/style.html");
        }
    function head() {
        return implode("", array("<head>",
        file_get_contents("page_parts/head.html"),
        $this->head_styling(),
        "</head>"));
    }

    function blog_general() {
        return "<div class=\"container\">
        <h1>Blog</h1>
        <p>Welcome '" . $this->user_welcome() . "' to the blog, where we share our thoughts on life, philosophy, and everything in between.
        </p>
        <img src='images/greek_building.jpg' />
    </div>";
    }

    function user_welcome() {
        if (!isset($_SESSION['user_name'])) {
            return "Guest";
        } else {
            return $_SESSION['user_name'];
        }
    }

    function logout_link() {
        return "<li><a href='logout.php'>Logout</a></li>";
    }

    function navbar_profile() {
        if (!isset($_SESSION['user_id'])) {
            // no one is logged in.
            // present thew login options
            return "<li><a href='register.php'>Register</a></li>
            <li><a href='login.php'>Login</a></li>";
        } elseif ($_SESSION['user_role'] == 'author') {
            // someone is loggedin as an author
            // give the option to create a new post 
            return "<li><a href='insertpost.php'>New Post</a></li>" . $this->logout_link();
        } else {
            // a subscriber has logged in
            return "<li>Welcome Reader '{$_SESSION['user_name']}'</li>" . $this->logout_link();
        }
    }

    function navbar() {
        return "<nav>
        <ul class='navbar'>
            <li><a href='index.php'>Home</a></li>
            <li><a href='displaypost.php'>Posts</a></li>
            " .
            $this->navbar_profile()
            . "
        </ul>
    </nav>";
    }

    function index_page() {
        return implode("", array("<!DOCTYPE html>
<html lang=\"en\">", $this->head(), "<body>", $this->navbar(), $this->blog_general(), $this->blogposts(), $this->footer(), "</body>
</html>"));
    }

    function page404($page_name) {
        return implode("", array("<!DOCTYPE html>
<html lang=\"en\">" , $this->head() , "<body>" , $this->navbar() , "<h2>404 Hello I could not find the page you where looking for. '$page_name'</h2>" , $this->footer() , "</body>
</html>"));
    }
    
    function posts_page() {
        return implode("", array("<!DOCTYPE html>
<html lang=\"en\">" , $this->head() , "<body>" , $this->navbar() , $this->blogposts() , $this->footer() , "</body>
</html>"));
    }

    function register_page() {
        return implode("", array("<!DOCTYPE html>
<html lang=\"en\">" , $this->head() , "<body>" , $this->navbar() , $this->register_form() , $this->footer() , "</body>
</html>"));
    }
    
    function insertpost_page() {
        return implode("", array("<!DOCTYPE html>
<html lang=\"en\">" , $this->head() , "<body>" , $this->navbar() , $this->new_post_form() , $this->footer() , "</body>
</html>"));
    }

    function updatepost_page() {
        return implode("", array("<!DOCTYPE html>
<html lang=\"en\">" , $this->head() , "<body>" , $this->navbar() , $this->update_post_form() , $this->footer() , "</body>
</html>"));
    }

    function login_page() {
        return implode("", array("<!DOCTYPE html>
<html lang=\"en\">" , $this->head() , "<body>" , $this->navbar() , $this->login_form() , $this->footer() , "</body>
</html>"));
    }

    function footer() {
        return "<footer>
  <p>Thank you for visiting our blog!</p>
</footer>";
    }

    function login_form() {
        return file_get_contents("page_parts/loginform.html");
    }

    function register_form() {
        return file_get_contents("page_parts/registerform.html");;
    }

    function new_post_form() {

        return implode("", array("<form action=\"insertpost.php\" method=\"POST\" enctype=\"multipart/form-data\">
            <input type=\"text\" name=\"title\" placeholder=\"Add your Post title\" required>
            <textarea name=\"content\" placeholder=\"Add your Post content here\" required></textarea>"
            , $this->post_category_selection() ,
            "<input type=\"file\" name=\"image\">
            <input type=\"submit\" name=\"submit\" value=\"Add Post\">
        </form>"));
    }

    function post_category_selection() {
        $result = query("SELECT * FROM categories");
        $options_html = "";

        while ($row = mysqli_fetch_assoc($result)) {
            $options_html = $options_html . "<option value=\"{$row['name']}\">{$row['name']}</option>";
        }

        return "<select name=\"category\" id=\"category\">" . $options_html . "
            </select>";
    }

    function update_post_form() {
        $result = query("SELECT * FROM categories");
        $options_html = "";

        while ($row = mysqli_fetch_assoc($result)) {
            $options_html = $options_html . "<option value=\"{$row['name']}\">{$row['name']}</option>";
        }


        return "<form action=\"updatepost.php\" method=\"POST\" enctype=\"multipart/form-data\">
            <input type=\"text\" name=\"title\" placeholder=\"Add your Post title\" required>
            <textarea name=\"content\" placeholder=\"Add your Post content here\" required></textarea>
            " . $this->post_category_selection() . "
            <input type=\"file\" name=\"image\">
            <input type=\"submit\" name=\"submit\" value=\"Update Post\">
        </form>";
    }

    function displayPost($post) {
        return "<div class=\"post\"><h2>" . $post['title'] . "</h2>
    <p>" . $post['content'] . "</p>
    <img src=\"images/" . $post['image'] . "\"/>" . $this->author_edit_post_controls($post) . "</div>";
    }

    function author_edit_post_controls($post) {
        if (!isset($_SESSION['user_id'])) {
            // no user is logged-in no controlls should be given
            return "";
        } elseif ($_SESSION['user_role'] == 'author') {
            // the authors may edit the posts
            
            return "<a class=\"link\" href=\"deletepost.php?post_id={$post['id']}\">Delete Post</a><a class=\"link\" href=\"updatepost.php?post_id={$post['id']}\">Edit Post</a>";
        } else {
            return "";
        }
    }

    function blogposts() {
        // we only want to display the posts if a user is logged in.
        if (!isset($_SESSION['user_id'])) {
            // no user is logged-in no controlls should be given
            return "<div class=\"blog-posts container\"> <div class=\"container\"><h2>Posts</h2>The posts are only available to logged in users.</div></div>";
        } else {
            $posts = query("SELECT * FROM posts");
            $post_html = "";
            while ($post = mysqli_fetch_assoc($posts)) {
                $post_html = $post_html . $this->displayPost($post);
            }
            return "<div class=\"blog-posts container\"> <div class=\"container\"><h2>Posts</h2></div>" . $post_html . "</div>";
        }
    }

    function page($name='index') {
        switch ($name) {
            case "register":
                return $this->register_page();
                break;
            case "login":
                return $this->login_page();
                break;
            case "posts":
                return $this->posts_page();
                break;
            case "index":
                return $this->index_page();
                break;
            case "insertpost":
                return $this->insertpost_page();
                break;
            case "updatepost":
                return $this->updatepost_page();
                break;
            default:
                return $this->page404($name);
        }
    }
}

?>