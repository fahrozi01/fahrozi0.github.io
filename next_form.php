<?php
include 'config.php';
include 'auth.php';
include 'pages/header.php';
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['qrcode'])) {
    $qrcode = $_GET['qrcode'];

    // Fetch item details using QR code
    $stmt = $pdo->prepare('SELECT * FROM items WHERE qrcode = ?');
    $stmt->execute([$qrcode]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$item) {
        header('Location: input.php'); // Redirect back if item not found
        exit();
    }
} else {
    header('Location: input.php'); // Redirect back if qrcode is not set
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Next Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <div class="container mt-5">
            <h1>Next Form Step</h1>
            <form method="POST" action="process_next_form.php">
                <div class="mb-3">
                    <label for="item_name" class="form-label">Item Name</label>
                    <input type="text" class="form-control" id="item_name" name="item_name" value="<?php echo htmlspecialchars($item['name']); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="sale_date" class="form-label">Sale Date</label>
                    <input type="date" class="form-control" id="sale_date" name="sale_date" required>
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" required>
                </div>
                <!-- Add more fields as necessary -->
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <?php 
include 'pages/footer.php';
?>
