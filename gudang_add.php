<?php
$conn = new mysqli("localhost", "root", "", "kasir_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : null;
    $price = isset($_POST['price']) ? (int)$_POST['price'] : null;
    $stock = isset($_POST['stock']) ? (int)$_POST['stock'] : null;

    // Validasi data
    if (empty($name) || $price <= 0 || $stock <= 0) {
        die("Data tidak valid.");
    }

    // Tambah barang ke tabel pending_items
    $stmt = $conn->prepare("INSERT INTO pending_items (name, price, stock, status) VALUES (?, ?, ?, 'pending')");
    $stmt->bind_param("sii", $name, $price, $stock);

    if ($stmt->execute()) {
        echo "Barang berhasil diajukan. Menunggu persetujuan dari manager.";
    } else {
        echo "Terjadi kesalahan: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
