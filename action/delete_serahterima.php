<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "app1";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM productivity WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: productivity.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid request";
}

$conn->close();
?>
