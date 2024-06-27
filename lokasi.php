<?php
include 'config.php';
include 'auth.php';
include 'pages/header.php';

// Fetch user data if needed
// Example: $result = $conn->query("SELECT * FROM users WHERE username = '".$_SESSION['username']."'");
require 'vendor/autoload.php'; // Pastikan sudah menginstall library PHP QR Code
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

function generateUniqueId() {
    return uniqid('id_', true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $unique_id = generateUniqueId();
    $name = $_POST['name'];
	$status_id = $_POST['status_id'];

    // Pastikan folder qrcodes ada
    if (!file_exists('qrcodes')) {
        mkdir('qrcodes', 0777, true);
    }

    // Save data to database
    $sql = "INSERT INTO locations (unique_id, name, status_id) VALUES ('$unique_id', '$name', '$status_id')";
    if ($conn->query($sql) === TRUE) {
        // Generate QR Code
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($unique_id)
            ->build();

        $qrCodePath = 'qrcodes/' . $unique_id . '.png';
        $result->saveToFile($qrCodePath);

        $success = "Lokasi Berhasil Ditambahkan.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
	// Delete user
	if (isset($_GET['delete'])) {
		$id = $_GET['delete'];
		$sql = "DELETE FROM locations WHERE unique_id='$id'";
		if ($conn->query($sql) === TRUE) {
			$success = "Lokasi Berhasil Dihapus.";
		} else {
			echo "Error deleting record: " . $conn->error;
		}
	}
?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Daftar Lokasi</h1>
          <?php if (isset($success)) { echo '<div class="alert alert-success">'.$success.'</div>'; } ?>
          <?php if (isset($error)) { echo '<div class="alert alert-danger">'.$error.'</div>'; } ?>
          <p class="mb-4">
          <button type="button" class="btn btn-primary" href="#" data-toggle="modal" data-target="#addlokasiModal">
              <i class="fas fa-truck fa-sm fa-fw mr-2 text-gray-400"></i>
              Lokasi
              </button>
          </p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Tabel Lokasi</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Kode QR</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>QR Code</th>
                    <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                $sql = "SELECT * FROM locations";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["unique_id"] . "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["status_id"] . "</td>";
                        echo "<td><img src='qrcodes/" . $row["unique_id"] . ".png' alt='QR Code' width='50'></td>";
                        echo "<td>
                                <a href='edit.php?edit=" . $row["unique_id"] . "' class='btn btn-success btn-sm'>
                                    <i class='fas fa-edit'></i>
                                </a>
                                <a href='lokasi.php?delete=" . $row["unique_id"] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>
                                    <i class='fas fa-trash-alt'></i>
                                </a>
                                <a href='view_qr.php?view=" . $row["unique_id"] . "' class='btn btn-info btn-sm'>
                                    <i class='fas fa-qrcode'></i>
                                </a>
                                <a href='users.php?approve=" . $row["unique_id"] . "' class='btn btn-primary btn-sm'>
                                    <i class='fas fa-check'></i>
                                </a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No data available</td></tr>";
                }
                ?>                 
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->
        </div>
        <!-- Logout Modal-->
  <div class="modal fade" id="addlokasiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Menambahkan Lokasi Pickup</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
                <form method="post" action="lokasi.php">
                    <div class="form-group">
                      <label for="name" class="form-label">Name</label>
                      <input type="text" class="form-control" id="name" name="name" onkeyup="this.value = this.value.toUpperCase()" required>
                    </div>
                    <div class="form-group">
                      <label for="status_id" class="form-label">Status Lokasi</label>
                      <select for="status_id" id="status_id" name="status_id" class="form-select" aria-label="Default select example" required>
                        <option selected>TIDAK ADA</option>
                        <option value="AGEN">AGEN</option>
                        <option value="CORPORATE">CORPORATE</option>
                      </select>
                    </div>

        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Register</button>
        </div>
      </div>
    </div>
  </div>
<?php 
include 'pages/footer.php';
?>
