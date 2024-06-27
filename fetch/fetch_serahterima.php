<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "app1";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 10;
$offset = ($page - 1) * $items_per_page;

$search_query = "";
if ($search) {
    $search_query = "WHERE id LIKE '%$search%' OR date LIKE '%$search%' OR time LIKE '%$search%' OR tasks_completed LIKE '%$search%' OR hours_worked LIKE '%$search%'";
}

// Menghitung total item
$total_sql = "SELECT COUNT(*) as total FROM productivity $search_query";
$total_result = $conn->query($total_sql);
$total_items = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_items / $items_per_page);

// Mengambil data dengan limit dan offset
$sql = "SELECT * FROM productivity $search_query LIMIT $items_per_page OFFSET $offset";
$result = $conn->query($sql);

$table = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $table .= "<tr>";
        $table .= "<td>" . $row["id"] . "</td>";
        $table .= "<td>" . $row["employee_id"] . "</td>";
        $table .= "<td>" . $row["date"] . "</td>";
        $table .= "<td>" . $row["time"] . "</td>";
        $table .= "<td>" . $row["tasks_completed"] . "</td>";
        $table .= "<td>" . $row["hours_worked"] . "</td>";
        $table .= "<td><img src='" . $row["photo"] . "' style='max-width: 100px; max-height: 100px;' /></td>";
        $table .= "<td><img src='" . $row["signature"] . "' style='max-width: 100px; max-height: 100px;' /></td>";
        $table .= "<td>";
        $table .= "<td><a href='action/edit_serahterima.php?id=" . $row["id"] . "' class='btn btn-primary'>Edit</a> </td>";
        $table .= "<td><a href='action/delete_serahterima.php?id=" . $row["id"] . "' class='btn btn-danger'>Delete</a></td> ";
        $table .= "<td><button type='button' class='btn btn-success' data-bs-toggle='modal' data-bs-target='#photoModal" . $row["id"] . "'>Aprrove</button></td>";
        $table .= "</tr>";

        // Modal untuk foto
        $table .= "<div class='modal fade' id='photoModal" . $row["id"] . "' tabindex='-1' aria-labelledby='photoModalLabel" . $row["id"] . "' aria-hidden='true'>";
        $table .= "<div class='modal-dialog'>";
        $table .= "<div class='modal-content'>";
        $table .= "<div class='modal-header'>";
        $table .= "<h5 class='modal-title' id='photoModalLabel" . $row["id"] . "'>Foto</h5>";
        $table .= "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
        $table .= "</div>";
        $table .= "<div class='modal-body'>";
        $table .= "<img src='" . $row["photo"] . "' style='max-width: 200%;' />";
        $table .= "<img src='" . $row["signature"] . "' style='max-width: 100%;' />";
        $table .= "</div>";
        $table .= "</div>";
        $table .= "</div>";

        // Modal untuk tanda tangan
        $table .= "<div class='modal fade' id='signatureModal" . $row["id"] . "' tabindex='-1' aria-labelledby='signatureModalLabel" . $row["id"] . "' aria-hidden='true'>";
        $table .= "<div class='modal-dialog'>";
        $table .= "<div class='modal-content'>";
        $table .= "<div class='modal-header'>";
        $table .= "<h5 class='modal-title' id='signatureModalLabel" . $row["id"] . "'>Tanda Tangan</h5>";
        $table .= "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
        $table .= "</div>";
        $table .= "<div class='modal-body'>";
        $table .= "<img src='" . $row["signature"] . "' style='max-width: 100%;' />";
        $table .= "</div>";
        $table .= "</div>";
        $table .= "</div>";
        $table .= "</div>";
    }
} else {
    $table .= "<tr><td colspan='8'>Tidak ada data</td></tr>";
}

// Membuat pagination
$pagination = '';
if ($total_pages > 1) {
    for ($i = 1; $i <= $total_pages; $i++) {
        $active = ($i == $page) ? 'active' : '';
        $pagination .= "<li class='page-item $active'><a class='page-link' href='#' data-page='$i'>$i</a></li>";
    }
}

$response = [
    'table' => $table,
    'pagination' => $pagination
];

echo json_encode($response);

$conn->close();
?>
