<?php
include 'config.php';
include 'auth.php';
include 'pages/header.php';

$location_id = isset($_GET['location_id']) ? $_GET['location_id'] : '';
$checkin_name = isset($_GET['checkin_name']) ? $_GET['checkin_name'] : '';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Item Sale</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</head>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Halaman User</h1>
    <p class="mb-4">
        <?php
        if (isset($_GET['message'])) {
            echo "<div class='alert alert-success'>" . htmlspecialchars($_GET['message']) . "</div>";
        }
        ?>
    </p>
    <div class="container">
        <form action="process_checkout.php" method="POST">
            <div class="form-group">
                <label for="record">Record</label>
                <select name="record_id" id="record" class="form-control" required>
                    <option value="">Select Record</option>
                    <?php
                    $sql = "SELECT records.id, records.location_id, locations.name, records.checkin_name, records.check_in 
                            FROM records 
                            JOIN locations ON records.location_id = locations.id 
                            WHERE records.check_out IS NULL";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        $selected = ($location_id == $row['location_id'] && $checkin_name == $row['checkin_name']) ? 'selected' : '';
                        echo "<option value='".$row['id']."' data-checkin='".$row['check_in']."' $selected>".$row['name']." - ".$row['checkin_name']." (Check-In: ".$row['check_in'].")</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="checkout_name">Nama Driver</label>
                <input type="text" name="checkout_name" value='<?php echo $_SESSION['username']; ?>' id="checkout_name" class="form-control" readonly required>
            </div>
            <div class="form-group">
                <label for="duration">Durasi (Jam)</label>
                <input type="text" name="duration" id="duration" class="form-control" readonly required>
            </div>
            <button type="submit" class="btn btn-success">Check-Out</button>
        </form>
    </div>
</div>
<script>
    function calculateDuration() {
        var recordSelect = document.getElementById('record');
        var checkinTime = new Date(recordSelect.options[recordSelect.selectedIndex].getAttribute('data-checkin'));
        var checkoutTime = new Date();
        var durationHours = Math.abs(checkoutTime - checkinTime) / 36e5;
        document.getElementById('duration').value = durationHours.toFixed(2);
        console.log("Check-in Time: " + checkinTime);
        console.log("Check-out Time: " + checkoutTime);
        console.log("Duration: " + durationHours);
    }

    document.getElementById('record').addEventListener('change', calculateDuration);

    // Call calculateDuration on page load if a record is already selected
    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('record').value !== "") {
            calculateDuration();
        }
    });
</script>
<?php 
include 'pages/footer.php';
?>
