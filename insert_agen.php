<?php
include 'config.php';
include 'auth.php';

// Mengambil data dari form
$lokasi_id = $_POST['lokasi_id'];
$pic_pickup = $_POST['pic_pickup'];
$date_pickup = $_POST['date_pickup'];
$time_pickup = $_POST['time_pickup'];
$pik_status = $_POST['pik_status'];
$connote = $_POST['connote'];
$koli = $_POST['koli'];
$photo1 = $_POST['photo1'];
$signature1 = $_POST['signature1'];

// Validasi data
if (empty($lokasi_id) || empty($pic_pickup) || empty($date_pickup) || empty($time_pickup) || empty($pik_status) || empty($connote) || empty($koli) || empty($photo1) || empty($signature1)) {
    die("Data tidak lengkap.");
}

// Menyiapkan query SQL menggunakan prepared statement
$stmt = $conn->prepare("INSERT INTO pickup (lokasi_id, pic_pickup, date_pickup, time_pickup, pik_status, connote, koli, photo1, signature1) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssisss", $lokasi_id, $pic_pickup, $date_pickup, $time_pickup, $pik_status, $connote, $koli, $photo1, $signature1);

// Menjalankan query dan mengecek hasilnya
if ($stmt->execute() === TRUE) {
    // Redirect ke halaman form input setelah sukses
    header("Location: inputagen.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// Menutup statement dan koneksi
$stmt->close();
$conn->close();
?>
