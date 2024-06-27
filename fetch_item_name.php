<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $qrcode = $_POST['qrcode'];

    $stmt = $pdo->prepare('SELECT name FROM items WHERE qrcode = ?');
    $stmt->execute([$qrcode]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($item) {
        echo $item['name'];
    } else {
        echo "Item not found";
    }
}
?>
