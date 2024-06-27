<?php
include 'config.php';
include 'auth.php';
include 'pages/header.php';

// Fetch user data if needed
// Example: $result = $conn->query("SELECT * FROM users WHERE username = '".$_SESSION['username']."'");
	// Delete user
	if (isset($_GET['delete'])) {
		$id = $_GET['delete'];
		$sql = "DELETE FROM pickup WHERE id='$id'";
		if ($conn->query($sql) === TRUE) {
			$success = "Data Pickup Berhasil Dihapus.";
		} else {
			echo "Error deleting record: " . $conn->error;
		}
	}
?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Daftar Scan Data</h1>
          <p class="mb-4">
          <?php if (isset($success)) { echo '<div class="alert alert-success">'.$success.'</div>'; } ?>
          <?php if (isset($error)) { echo '<div class="alert alert-danger">'.$error.'</div>'; } ?>
          </p>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Data Scan</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                  <tr>
                        <th>Id</th>
                        <th>Lokasi</th>
                        <th>Driver</th>
                        <th>Tgl Pickup</th>
                        <th>Jam Pickup</th>
                        <th>Tgl Approve</th>
                        <th>Jam Approve</th>
                        <th>PIC Approve</th>
                        <th>Status Pickup</th>
                        <th>Jumlah Connote</th>
                        <th>Jumlah Koli</th>
                        <th>Foto Pickup</th>
                        <th>Foto Receiving</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                $sql = "SELECT * FROM pickup";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["lokasi_id"] . "</td>";
                        echo "<td>" . $row["pic_pickup"] . "</td>";
                        echo "<td>" . $row["date_pickup"] . "</td>";
                        echo "<td>" . $row["time_pickup"] . "</td>";
                        echo "<td>" . $row["date_approve"] . "</td>";
                        echo "<td>" . $row["time_approve"] . "</td>";
                        echo "<td>" . $row["pic_approve"] . "</td>";
                        echo "<td>" . $row["pik_status"] . "</td>";
                        echo "<td>" . $row["connote"] . "</td>";
                        echo "<td>" . $row["koli"] . "</td>";
                        echo "<td><img src='" . $row["photo1"] . "' style='max-width: 100px; max-height: 100px;' /></td>";
                        echo "<td><img src='" . $row["photo2"] . "' style='max-width: 100px; max-height: 100px;' /></td>";
                        echo "<td>
                                <a href='edit.php?edit=" . $row["id"] . "' class='btn btn-success btn-sm'>
                                    <i class='fas fa-edit'></i>
                                </a>
                                <a href='data.php?delete=" . $row["id"] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>
                                    <i class='fas fa-trash-alt'></i>
                                </a>
                                <a href='users.php?approve=" . $row["id"] . "' class='btn btn-primary btn-sm'>
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
<?php 
include 'pages/footer.php';
?>
