<?php
include 'config.php';
include 'auth.php';
include 'pages/header.php';

// Fetch user data if needed
// Example: $result = $conn->query("SELECT * FROM users WHERE username = '".$_SESSION['username']."'");

?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
        <!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Data Pickup</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID Agen</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Jumlah Connote</th>
                    <th>Jumlah Koli</th>
                    <th>Foto</th>
                    <th>Tanda Tangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Mengambil data dari tabel productivity
                $sql = "SELECT * FROM productivity";
                $result = $conn->query($sql);

                // Menampilkan data dalam tabel
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["date"] . "</td>";
                        echo "<td>" . $row["time"] . "</td>";
                        echo "<td>" . $row["tasks_completed"] . "</td>";
                        echo "<td>" . $row["hours_worked"] . "</td>";
                        echo "<td><img src='" . $row["photo"] . "' style='max-width: 100px; max-height: 100px;' /></td>";
                        echo "<td><img src='" . $row["signature"] . "' style='max-width: 100px; max-height: 100px;' /></td>";
                        echo "<td>";
                        echo "<a href='edit.php?id=" . $row["id"] . "' class='btn btn-primary'>Edit</a> ";
                        echo "<a href='delete.php?id=" . $row["id"] . "' class='btn btn-danger'> Delete</a> ";
                        echo "<button type='button' class='btn btn-success' data-bs-toggle='modal' data-bs-target='#photoModal" . $row["id"] . "'>Lihat Foto</button>";
                        echo "</tr>";

                        // Modal untuk foto
                        echo "<div class='modal fade' id='photoModal" . $row["id"] . "' tabindex='-1' aria-labelledby='photoModalLabel" . $row["id"] . "' aria-hidden='true'>";
                        echo "<div class='modal-dialog'>";
                        echo "<div class='modal-content'>";
                        echo "<div class='modal-header'>";
                        echo "<h5 class='modal-title' id='photoModalLabel" . $row["id"] . "'>Foto</h5>";
                        echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                        echo "</div>";
                        echo "<div class='modal-body'>";
                        echo "<img src='" . $row["photo"] . "' style='max-width: 200%;' />";
                        echo "<img src='" . $row["signature"] . "' style='max-width: 100%;' />";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";

                        // Modal untuk tanda tangan
                        echo "<div class='modal fade' id='signatureModal" . $row["id"] . "' tabindex='-1' aria-labelledby='signatureModalLabel" . $row["id"] . "' aria-hidden='true'>";
                        echo "<div class='modal-dialog'>";
                        echo "<div class='modal-content'>";
                        echo "<div class='modal-header'>";
                        echo "<h5 class='modal-title' id='signatureModalLabel" . $row["id"] . "'>Tanda Tangan</h5>";
                        echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                        echo "</div>";
                        echo "<div class='modal-body'>";
                        echo "<img src='" . $row["signature"] . "' style='max-width: 100%;' />";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Tidak ada data</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>


        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
<?php 
include 'pages/footer.php';
?>