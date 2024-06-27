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

$id = $_GET['id'];

$sql = "SELECT id, col1, col2, col3, col4, date, col6, col7, col8, col9 FROM produktifitas WHERE id='$id'";
$result = $conn->query($sql);

$data = $result->fetch_assoc();

echo json_encode($data);

$conn->close();
?>
