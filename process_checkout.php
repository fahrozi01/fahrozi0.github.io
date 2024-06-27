<?php
include 'config.php';
include 'auth.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $record_id = $_POST['record_id'];
    $checkout_name = $_POST['checkout_name'];
    $duration = $_POST['duration'];

    // Debug output
    echo "Record ID: $record_id<br>";
    echo "Checkout Name: $checkout_name<br>";
    echo "Duration: $duration<br>";

    // Ensure the variables are properly set
    if (!empty($record_id) && !empty($checkout_name) && !empty($duration)) {
        // Update the record with the checkout name, checkout time, and duration
        $sql = "UPDATE records SET check_out = NOW(), checkout_name = ?, duration = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdi", $checkout_name, $duration, $record_id);

        if ($stmt->execute()) {
            // Redirect with a success message
            header("Location: inputcorp.php?message=Checkout successful");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "All fields are required.";
    }
}

$conn->close();
?>
