<?php
$server = "localhost";
$user = "root";
$pass = "";
$dbname = "stoa";

$conn = new mysqli($server, $user, $pass, $dbname);
if (!$conn) {
    echo "Connection Error: {$conn->connect_error}";
} else {
    echo "DB Connection established!";
}

?>