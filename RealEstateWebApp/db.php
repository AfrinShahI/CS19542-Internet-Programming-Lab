<?php
$servername = "localhost";
$username = "root";
$password = "afrinshah";
$dbname = "real_estate";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
