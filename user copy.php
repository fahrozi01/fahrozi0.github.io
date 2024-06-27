<?php
include 'config.php';
include 'auth.php';
include 'pages/header.php';

// Fetch user data if needed
// Example: $result = $conn->query("SELECT * FROM users WHERE username = '".$_SESSION['username']."'");

// Pastikan hanya admin yang dapat mengakses halaman ini
if ($_SESSION['role'] != 'admin') {
  header("Location: user.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
  $nik = $_POST['nik'];
  $nama = $_POST['nama'];
  $role = $_POST['role'];

  $stmt = $conn->prepare("INSERT INTO users (username, password, nik, nama, role) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $username, $password, $nik, $nama, $role);

  if ($stmt->execute()) {
      $success = "User registered successfully.";
  } else {
      $error = "Error: " . $stmt->error;
  }
  $stmt->close();
}

?>
      <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Daftar User</h1>
          <?php if (isset($success)) { echo '<div class="alert alert-success">'.$success.'</div>'; } ?>
          <?php if (isset($error)) { echo '<div class="alert alert-danger">'.$error.'</div>'; } ?>
          <p class="mb-4">
              <button type="button" class="btn btn-primary" href="#" data-toggle="modal" data-target="#adduserModal">
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
              User
              </button>
          </p>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Data User</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="data-table" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Nik</th>
                        <th>Nama</th>
                        <th>Rule</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                <?php
                // Mengambil data dari tabel productivity
                $sql = "SELECT * FROM users";
                $result = $conn->query($sql);

                // Menampilkan data dalam tabel
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["username"] . "</td>";
                        echo "<td>" . $row["nik"] . "</td>";
                        echo "<td>" . $row["nama"] . "</td>";
                        echo "<td>" . $row["role"] . "</td>";
                        echo "<td>";
                        echo "<a href='edit.php?id=" . $row["id"] . "' class='btn btn-primary'>Edit</a> ";
                        echo "<a href='delete.php?id=" . $row["id"] . "' class='btn btn-danger'> Delete</a> ";
                        echo "<button type='button' class='btn btn-success' data-bs-toggle='modal' data-bs-target='#photoModal" . $row["id"] . "'>Lihat Profil</button>";
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
                    }
                } else {
                    echo "<tr><td colspan='8'>Tidak ada data</td></tr>";
                }
                $conn->close();
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
  <div class="modal fade" id="adduserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Menambahkan User pada Aplikasi</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
                <form method="post" action="user.php">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" onkeyup="this.value = this.value.toUpperCase()" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" onkeyup="this.value = this.value.toUpperCase()" required>
                    </div>
                    <div class="form-group">
                        <label>NIK</label>
                        <input type="text" name="nik" class="form-control" onkeyup="this.value = this.value.toUpperCase()" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" onkeyup="this.value = this.value.toUpperCase()" required>
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="form-control" required>
                            <option value="admin">Admin</option>
                            <option value="manager">Manager</option>
                            <option value="employee">Employee</option>
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