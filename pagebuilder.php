<?php
include_once "db.php";


class PageBuilder {
    function __construct() {

    }

    function head_styling() {
        return "<style>
    body {
        background-color: #f8f9fa;
    }

    .container {
        margin: 0 auto;
        max-width: 1200px;
        padding: 40px;
        border: 1px solid #ddd;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    h1 {
        font-size: 36px;
        margin: 20px 0;
        color: #2e587b;
    }

    p {
        font-size: 20px;
        margin: 20px 0;
        color: #4f4f4f;
    }

    .blog-posts {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        padding: 1rem;
        background-color: #2e587b;
        color: #fff;
    }

    .post {
        margin: 1rem;
        padding: 0.5rem;
        width: 100%;
        border: 1px solid #ddd;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .link {
        display: block;
        margin: 0 1rem;
        padding: 1rem;
        border: 1px solid #ff914d;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        color: #fff;
        float: right;
    }

    .link:hover {
        text-decoration-line: none;
        border: 1px solid #515151;
        color: #ff914d;
    }

    .post h2 {
        font-size: 24px;
        margin: 20px 0;
        color: #fff;
    }

    .post p {
        font-size: 18px;
        margin: 20px 0;
        color: #fff;
    }

    img {
        display: block;
        margin: auto;
    }

    nav {
        color: #fff;
        background-color: #2e587b;
        margin: 0 0 2rem 0;
    }

    nav ul {
        list-style: none;
        display: flex;
        justify-content: space-between;
    }

    nav a {
        color: #fff;
        text-decoration: none;
        padding: 1rem;
        margin: 0.5rem;
    }

    nav a:hover {
        color: #ff914d;
    }

    nav li {
        padding: 2rem;
    }

    nav li a i {
        font-size: 24px;
        margin-right: 10px;
    }

    form {
        color: #000;
        width: 80%;
        margin: 2rem auto;
        padding: 1rem;
        background-color: #fff;
        border: 1px solid #ddd;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    input[type=\"text\"],
    textarea {
        display: block;
        width: 100%;
        padding: 1rem;
        margin-bottom: 1rem;
        border: none;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }
    input[type=\"password\"],
    textarea {
        display: block;
        width: 100%;
        padding: 1rem;
        margin-bottom: 1rem;
        border: none;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    select {
        display: block;
        width: 100%;
        padding: 1rem;
        margin-bottom: 1rem;
        border: none;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    input[type=\"file\"] {
        display: block;
        width: 100%;
        padding: 1rem;
        margin-bottom: 1rem;
        border: none;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    input[type=\"submit\"] {
        display: block;
        width: 100%;
        padding: 1rem;
        margin-bottom: 1rem;
        border: none;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        background-color: #2e587b;
        color: #fff;
        }
        
    input[type=\"submit\"]:hover {
        color: #ff914d;
    }

    footer {
        background-color: #2e587b;
        padding: 1rem;
        margin: 2rem 0 0 0;
    }

    footer p {
        color: #fff;
        font-size: 16px;
        text-align: center;
    }
        </style>";
        }
            
            
    function head() {
        return "<head>
        <meta charset=\"UTF-8\">
        <title>Blog</title>
        <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css\">
        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js\"></script>
        <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js\"></script>
        " . $this->head_styling() . "</head>";
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
        return "<!DOCTYPE html>
<html lang=\"en\">" . $this->head() . "<body>" . $this->navbar() . $this->blog_general() . $this->blogposts() . $this->footer() . "</body>
</html>";
    }

    function defaulting($page_name) {
        return "<!DOCTYPE html>
<html lang=\"en\">" . $this->head() . "<body>" . $this->navbar() . "<h2>404 Hello I could not find the page you where looking for. '$page_name'</h2>" . $this->footer() . "</body>
</html>";
    }
    
    function posts_page() {
        return "<!DOCTYPE html>
<html lang=\"en\">" . $this->head() . "<body>" . $this->navbar() . $this->blogposts() . $this->footer() . "</body>
</html>";
    }

    function register_page() {
        return "<!DOCTYPE html>
<html lang=\"en\">" . $this->head() . "<body>" . $this->navbar() . $this->register_form() . $this->footer() . "</body>
</html>";
    }
    
    function insertpost_page() {
        return "<!DOCTYPE html>
<html lang=\"en\">" . $this->head() . "<body>" . $this->navbar() . $this->new_post_form() . $this->footer() . "</body>
</html>";
    }

    function login_page() {
        return "<!DOCTYPE html>
<html lang=\"en\">" . $this->head() . "<body>" . $this->navbar() . $this->login_form() . $this->footer() . "</body>
</html>";
    }

    function footer() {
        return "<footer>
  <p>Thank you for visiting our blog!</p>
</footer>";
    }

    function login_form() {
        return "<form action=\"login.php\" method=\"POST\">
        <div class=\"container\">
            <h1>Login</h1>
            <p>Get back to posting.</p>
            <hr>

            <label for=\"name\"><b>Name</b></label>
            <input type=\"text\" placeholder=\"Enter name\" name=\"name\" id=\"name\" required>

            <label for=\"psw\"><b>Password</b></label>
            <input type=\"password\" placeholder=\"Enter Password\" name=\"psw\" id=\"psw\" required>
            <hr>

            <button type=\"submit\" name=\"submit\" class=\"loginbtn\">Login</button>
            </div>

            <div class=\"container signin\">
            <p>No account yet? <a href=\"register.php\">Register here</a>.</p>
        </div>
    </form>";
    }

    function register_form() {
        return "<form action=\"register.php\" method=\"POST\">
        <div class=\"container\">
            <h1>Register</h1>
            <p>Please fill in this form to create an account.</p>
            <hr>

            <label for=\"name\"><b>Name</b></label>
            <input type=\"text\" placeholder=\"Enter name\" name=\"name\" id=\"name\" required>

            <label for=\"psw\"><b>Password</b></label>
            <input type=\"password\" placeholder=\"Enter Password\" name=\"psw\" id=\"psw\" required>

            <select name=\"role\">
                <option value=\"subscriber\">Subscriber</option>
                <option value=\"author\">Author</option>
            </select>
            <hr>

            <button type=\"submit\" name=\"submit\" class=\"registerbtn\">Register</button>
            </div>

            <div class=\"container signin\">
            <p>Already have an account? <a href=\"login.php\">Sign in</a>.</p>
        </div>
    </form>";
    }

    function new_post_form() {
        $result = query("SELECT * FROM categories");
        $options_html = "";

        while ($row = mysqli_fetch_assoc($result)) {
            $options_html = $options_html . "<option value=\"{$row['name']}\">{$row['name']}</option>";
        }


        return "<form action=\"insertpost.php\" method=\"POST\" enctype=\"multipart/form-data\">
            <input type=\"text\" name=\"title\" placeholder=\"Add your Post title\" required>
            <textarea name=\"content\" placeholder=\"Add your Post content here\" required></textarea>
            <select name=\"category\" id=\"category\">" . $options_html . "
            </select>
            <input type=\"file\" name=\"image\">
            <input type=\"submit\" name=\"submit\" value=\"Add Post\">
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
            default:
                return $this->defaulting($name);
        }
    }
}

?>