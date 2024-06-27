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
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
          </div>
                    <!-- Content Row -->
                    <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pickup</div>
                    <?php
                    $sqlpickup = "SELECT COUNT(*) AS pickupCount FROM records";
                    $resultpickup = $conn->query($sqlpickup);
                    $rowpickup = $resultpickup->fetch_assoc();
                    $pickupCount = $rowpickup['pickupCount'];
                    ?>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo "<p class='card-text'>$pickupCount</p>"; ?>
                    </div>
                    </div>
                    <div class="col-auto">
                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
                </div>
            </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Petugas</div>
                    <?php
                    $sqlusers = "SELECT COUNT(*) AS usersCount FROM users";
                    $resultusers = $conn->query($sqlusers);
                    $rowusers = $resultusers->fetch_assoc();
                    $usersCount = $rowusers['usersCount'];
                    ?> 
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo "<p class='card-text'>$usersCount</p>"; ?></div>
                    </div>
                    <div class="col-auto">
                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
                </div>
            </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Produktifitas</div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                        </div>
                        <div class="col">
                        <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
                </div>
            </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Jumlah Lokasi</div>
                    <?php
                    $sqllokasi = "SELECT COUNT(*) AS lokasiCount FROM locations";
                    $resultlokasi = $conn->query($sqllokasi);
                    $rowlokasi = $resultlokasi->fetch_assoc();
                    $lokasiCount = $rowlokasi['lokasiCount'];
                    ?>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo "<p class='card-text'>$lokasiCount</p>"; ?></div>
                    </div>
                    <div class="col-auto">
                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
                </div>
            </div>
            </div>
            </div>

            <!-- Content Row -->

            <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Total Connote</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Dropdown Header:</div>
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="myAreaChart"></canvas>
                        </div>
                        <?php
                            // Koneksikan ke database
                            $kon = mysqli_connect("localhost","root","","app3");
                            //Inisialisasi nilai variabel awal
                            $nama_hk= "";
                            $jumlah=null;
                            //Query SQL
                            $sql="select location_id,COUNT(*) as 'total' from records GROUP by location_id";
                            $hasil=mysqli_query($kon,$sql);

                            while ($data = mysqli_fetch_array($hasil)) {
                                //Mengambil nilai jurusan dari database
                                $jur=$data['location_id'];
                                $nama_hk .= "'$jur'". ", ";
                                //Mengambil nilai total dari database
                                $jum=$data['location_id'];
                                $jumlah .= "$jum". ", ";

                            }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Total Pickup Lokasi</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Dropdown Header:</div>
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="PieChart"></canvas>
                </div>
                <div class="mt-4 text-center small">
                    <span class="mr-2">
                    <?php
                    // Koneksikan ke database
                    $kon = mysqli_connect("localhost","root","","app3");
                    //Inisialisasi nilai variabel awal
                    $nama_hk= "";
                    $jumlah=null;
                    //Query SQL
                    $sql="select location_id,COUNT(*) as 'total' from records GROUP by location_id";
                    $hasil=mysqli_query($kon,$sql);

                    while ($data = mysqli_fetch_array($hasil)) {
                        //Mengambil nilai jurusan dari database
                        $jur=$data['location_id'];
                        $nama_hk .= "'$jur'". ", ";
                        //Mengambil nilai total dari database
                        $jum=$data['location_id'];
                        $jumlah .= "$jum". ", ";

                    }
                    ?>
                    </span>
                </div>
                </div>
            </div>
            </div>
            </div>

            <!-- Content Row -->
            <div class="row">

            <!-- Content Column -->
            <div class="col-lg-6 mb-4">

            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Projects</h6>
                </div>
                <div class="card-body">
                <h4 class="small font-weight-bold">Server Migration <span class="float-right">20%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Sales Tracking <span class="float-right">40%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Customer Database <span class="float-right">60%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Payout Details <span class="float-right">80%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Account Setup <span class="float-right">Complete!</span></h4>
                <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                </div>
            </div>

            <!-- Color System -->
            <div class="row">
                <div class="col-lg-6 mb-4">
                <div class="card bg-primary text-white shadow">
                    <div class="card-body">
                    Primary
                    <div class="text-white-50 small">#4e73df</div>
                    </div>
                </div>
                </div>
                <div class="col-lg-6 mb-4">
                <div class="card bg-success text-white shadow">
                    <div class="card-body">
                    Success
                    <div class="text-white-50 small">#1cc88a</div>
                    </div>
                </div>
                </div>
                <div class="col-lg-6 mb-4">
                <div class="card bg-info text-white shadow">
                    <div class="card-body">
                    Info
                    <div class="text-white-50 small">#36b9cc</div>
                    </div>
                </div>
                </div>
                <div class="col-lg-6 mb-4">
                <div class="card bg-warning text-white shadow">
                    <div class="card-body">
                    Warning
                    <div class="text-white-50 small">#f6c23e</div>
                    </div>
                </div>
                </div>
                <div class="col-lg-6 mb-4">
                <div class="card bg-danger text-white shadow">
                    <div class="card-body">
                    Danger
                    <div class="text-white-50 small">#e74a3b</div>
                    </div>
                </div>
                </div>
                <div class="col-lg-6 mb-4">
                <div class="card bg-secondary text-white shadow">
                    <div class="card-body">
                    Secondary
                    <div class="text-white-50 small">#858796</div>
                    </div>
                </div>
                </div>
                <div class="col-lg-6 mb-4">
                <div class="card bg-light text-black shadow">
                    <div class="card-body">
                    Light
                    <div class="text-black-50 small">#f8f9fc</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-dark text-white shadow">
                <div class="card-body">
                    Dark
                    <div class="text-white-50 small">#5a5c69</div>
                </div>
                </div>
            </div>
            </div>

            </div>

            <div class="col-lg-6 mb-4">

            <!-- Illustrations -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Illustrations</h6>
                </div>
                <div class="card-body">
                <div class="text-center">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="img/undraw_posting_photo.svg" alt="">
                </div>
                <p>Add some quality, svg illustrations to your project courtesy of <a target="_blank" rel="nofollow" href="https://undraw.co/">unDraw</a>, a constantly updated collection of beautiful svg images that you can use completely free and without attribution!</p>
                <a target="_blank" rel="nofollow" href="https://undraw.co/">Browse Illustrations on unDraw &rarr;</a>
                </div>
            </div>

            </div>
            </div>

        </div>
        
        <!-- /.container-fluid -->

     <!-- Page level plugins -->
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>
    <script>
        
    // Performance Chart
    var ctx = document.getElementById('myAreaChart').getContext('2d');
    var performanceChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                label: 'Data Scan',
                data: [10, 20, 15, 25, 30, 35, 40],
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                fill: false
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    // Fetch data for HK
    var ctx = document.getElementById('PieChart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'pie',
        // The data for our dataset
        data: {
            labels: [<?php echo $nama_hk; ?>],
            datasets: [{
                label:'Data Transaksi ',
                backgroundColor: ['rgb(255, 99, 132)', 'rgba(56, 86, 255, 0.87)', 'rgb(60, 179, 113)','rgb(175, 238, 239)','rgb(135, 278, 279)','rgb(75, 38, 139)'],
                borderColor: ['rgb(255, 99, 132)'],
                data: [<?php echo $jumlah; ?>]
            }]
        },

        // Configuration options go here
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
</script>

<?php 
include 'pages/footer.php';
?>