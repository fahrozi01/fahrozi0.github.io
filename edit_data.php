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
$col1 = $_POST['col1'];
$col2 = $_POST['col2'];
$col3 = $_POST['col3'];
$col4 = $_POST['col4'];
$date = $_POST['date'];
$col5 = $_POST['col5'];
$col6 = $_POST['col6'];
$col7 = $_POST['col7'];
$col8 = $_POST['col8'];
$col9 = $_POST['col9'];

$sql = "UPDATE produktifitas SET col1='$col1', col2='$col2', col3='$col3', col4='$col4', date='$date' col6='$col6', col7='$col7', col8='$col8', col9='$col9' WHERE id='$id'";
$conn->query($sql);

$conn->close();
?>
