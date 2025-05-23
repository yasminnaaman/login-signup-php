<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_account"; // <- change this to your DB name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
