<?php
session_start();

include "pagebuilder.php";
$pb = new PageBuilder();

// show the homepage of the blog
echo $pb->page('index');
?>