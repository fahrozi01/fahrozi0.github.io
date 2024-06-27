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
    // Update status atau melakukan aksi lainnya
    // Contoh: $sql = "UPDATE productivity SET status='accepted' WHERE id=$id";
    // Sesuaikan dengan kebutuhan aplikasi Anda
    header("Location: productivity.php");
    exit();
} else {
    echo "Invalid request";
}

$conn->close();
?>
