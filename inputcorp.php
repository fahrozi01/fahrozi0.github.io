<?php
include 'config.php';
include 'auth.php';
include 'pages/header.php';

// Fetch user data if needed
// Example: $result = $conn->query("SELECT * FROM users WHERE username = '".$_SESSION['username']."'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Check-In</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Check-In</h2>
        <?php
        if (isset($_GET['message'])) {
            echo "<div class='alert alert-success'>" . htmlspecialchars($_GET['message']) . "</div>";
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $location_id = $_POST['location_id'];
            $checkin_name = $_POST['checkin_name'];

            // Check if there's already an active check-in for the selected location
            $sql = "SELECT * FROM records WHERE location_id = ? AND check_out IS NULL";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $location_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $checkin_name = $row['checkin_name'];
                echo "<div class='alert alert-warning'>Location is already checked in by $checkin_name. Redirecting to Check-Out...</div>";
                echo "<script>alert('Anda Telah Checkin, Silahkan Checkout'); window.location.href='checkout.php?location_id=$location_id&checkin_name=$checkin_name';</script>";
            } else {
                // No active check-in found, proceed with check-in
                $sql = "INSERT INTO records (location_id, checkin_name) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("is", $location_id, $checkin_name);

                if ($stmt->execute()) {
                     // Redirect to checkin.php after successful check-out
                     echo "<script>alert('Check-in success!'); window.location.href='inputcorp.php';</script>";
                    exit();
                } else {
                    echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
                }
            }

            $stmt->close();
            $conn->close();
        }
        ?>
        <form action="inputcorp.php" method="POST">
            <div class="form-group">
                <label for="location">Location</label>
                <select name="location_id" id="location" class="form-control" required>
                    <option value="">Select Location</option>
                    <?php
                    $sql = "SELECT * FROM locations";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='".$row['id']."'>".$row['name']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="checkin_name">Nama Driver</label>
                <input type="text" name="checkin_name" value='<?php echo $_SESSION['username']; ?>' id="checkin_name" class="form-control" readonly required>
            </div>
            <button type="submit" class="btn btn-primary">Check-In</button>
        </form>
    </div>
   
<?php 
include 'pages/footer.php';
?>