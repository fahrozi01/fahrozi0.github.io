<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

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

if (isset($_FILES['file'])) {
    $file = $_FILES['file']['tmp_name'];
    $spreadsheet = IOFactory::load($file);
    $sheetData = $spreadsheet->getActiveSheet()->toArray();

    $success = true;
    
    // Start from the second row
    for ($i = 1; $i < count($sheetData); $i++) {
        $row = $sheetData[$i];
        $col1 = $row[0];
        $col2 = $row[1];
        $col3 = $row[2];
        $col4 = $row[3];
        $date = $row[4];
        $col6 = $row[5];
        $col7 = $row[6];
        $col8 = $row[7];
        $col9 = $row[8];
        $col10 = $row[9];
        // Add more columns as needed

        $sql = "INSERT INTO produktifitas (col1, col2, col3, col4, date, col6, col7, col8, col9, col10) VALUES ('$col1', '$col2', '$col3', '$col4', '$date', '$col6', '$col7', '$col8', '$col9', '$col10')";
        if ($conn->query($sql) !== TRUE) {
            $success = false;
            break;
        }
    }

    $conn->close();

    if ($success) {
        echo "<script>alert('Upload successful!'); window.location.href = 'upload.php';</script>";
    } else {
        echo "<script>alert('Upload failed. Please try again.'); window.location.href = 'upload.php';</script>";
    }
}
?>
