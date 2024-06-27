<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="d-flex" id="wrapper">
        <?php include 'includes/sidebar.php'; ?>
        <div class="container mt-5">
            <h1>Success</h1>
            <div class="alert alert-success" role="alert">
                The operation was successful!
            </div>
            <a href="sell_item.php" class="btn btn-primary">Record Another Sale</a>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
