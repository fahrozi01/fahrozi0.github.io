<?php
include 'config.php';
include 'auth.php';
include 'pages/header.php';

// Fetch user data if needed
// Example: $result = $conn->query("SELECT * FROM users WHERE username = '".$_SESSION['username']."'");

?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Data Serah Terima</h1>
  <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Tabel Serah Terima</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Action</th>
              <th>Lokasi</th>
              <th>Driver Checkin</th>
              <th>Driver Checkout</th>
              <th>Tgl Checkin</th>
              <th>Tgl Checkout</th>
              <th>Durasi</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $sql = "SELECT records.*, locations.name AS location_name FROM records JOIN locations ON records.location_id = locations.id";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>
                          <a href='edit.php?edit=" . $row["id"] . "' class='btn btn-success btn-sm'>
                              <i class='fas fa-edit'></i>
                          </a>
                          <a href='users.php?delete=" . $row["id"] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>
                              <i class='fas fa-trash-alt'></i>
                          </a>
                          <a href='users.php?approve=" . $row["id"] . "' class='btn btn-primary btn-sm'>
                              <i class='fas fa-check'></i>
                          </a>
                        </td>";
                  echo "<td>" . $row["location_name"] . "</td>";
                  echo "<td>" . $row["checkin_name"] . "</td>";
                  echo "<td>" . $row["checkout_name"] . "</td>";
                  echo "<td>" . $row["check_in"] . "</td>";
                  echo "<td>" . $row["check_out"] . "</td>";
                  echo "<td>" . $row["duration"] . "</td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='7'>No data available</td></tr>";
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
