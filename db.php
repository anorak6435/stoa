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

?>