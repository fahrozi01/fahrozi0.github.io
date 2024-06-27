<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "app1";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $tasks_completed = $_POST['tasks_completed'];
    $hours_worked = $_POST['hours_worked'];

    $sql = "UPDATE productivity SET tasks_completed='$tasks_completed', hours_worked='$hours_worked' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../serahterima.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Invalid request";
}

$conn->close();
?>
