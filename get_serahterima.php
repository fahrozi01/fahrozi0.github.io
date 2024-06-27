<?php
include 'config.php';

$sql = "SELECT * FROM records ORDER BY check_in DESC";
$result = $conn->query($sql);

$records = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $records[] = $row;
    }
}

echo json_encode($records);

$conn->close();
?>
