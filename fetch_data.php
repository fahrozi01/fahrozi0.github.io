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

$date = isset($_GET['date']) ? $_GET['date'] : '';

$sql = "SELECT id, lokasi_id, date_pickup, , col4, date, col6, col7, col8, col9 FROM produktifitas"; // Add more columns as needed
if ($date) {
    $sql .= " WHERE DATE(date) = '$date'";
}

$result = $conn->query($sql);

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(array('data' => $data));

$conn->close();
?>
