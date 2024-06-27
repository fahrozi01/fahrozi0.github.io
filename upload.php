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
          <h1 class="h3 mb-2 text-gray-800">Halaman User</h1>
          <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>
            <div class="container mt-5">
                <h2>Upload Excel File</h2>
                <form action="fetch_upload.php" method="post" enctype="multipart/form-data" class="mb-5">
                    <div class="form-group">
                        <label for="file">Choose Excel File</label>
                        <input type="file" name="file" id="file" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>

            </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
<?php 
include 'pages/footer.php';
?>