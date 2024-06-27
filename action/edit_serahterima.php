<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Produktivitas Karyawan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Data Serah Terima</h1>
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
            $sql = "SELECT * FROM productivity WHERE id=$id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                // Form untuk edit data
                echo "<form action='update_serahterima.php' method='POST'>";
                echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                echo "<div class='mb-3'>";
                echo "<label for='tasks_completed' class='form-label'>Jumlah Connote</label>";
                echo "<input type='number' class='form-control' id='tasks_completed' name='tasks_completed' value='" . $row["tasks_completed"] . "' required>";
                echo "</div>";
                echo "<div class='mb-3'>";
                echo "<label for='hours_worked' class='form-label'>Jumlah Koli</label>";
                echo "<input type='number' step='0.1' class='form-control' id='hours_worked' name='hours_worked' value='" . $row["hours_worked"] . "' required>";
                echo "<div>";
                echo "<img src='" . $row["photo"] . "' style='max-width: 200%;' />";
                echo "</div>";
                echo "</div>";
                echo "<button type='submit' class='btn btn-primary'>Submit</button>";
                echo "</form>";
            } else {
                echo "Data not found";
            }
        } else {
            echo "Invalid request";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
