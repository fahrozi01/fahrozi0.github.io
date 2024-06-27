<?php
$host = 'localhost';
$db = 'app1';
$user = 'root';
$pass = '';

// Create a connection to the database
$conn = new mysqli($host, $user, $pass, $db);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];

$sql = "DELETE FROM produktifitas WHERE id='$id'";
$conn->query($sql);

$conn->close();
?>
