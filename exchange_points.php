<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kasir_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data POST
$data = json_decode(file_get_contents('php://input'), true);

$memberId = $data['memberId'];
$itemId = $data['itemId'];
$quantity = $data['quantity'];
$totalPointsRequired = $data['totalPointsRequired'];

// Ambil poin member
$sql = "SELECT points FROM members WHERE id = $memberId";
$result = $conn->query($sql);
$member = $result->fetch_assoc();

if ($member && $member['points'] >= $totalPointsRequired) {
    // Kurangi poin member
    $newPoints = $member['points'] - $totalPointsRequired;
    $sqlUpdate = "UPDATE members SET points = $newPoints WHERE id = $memberId";
    $conn->query($sqlUpdate);

    // Simpan riwayat penukaran
    $sqlInsert = "INSERT INTO exchange_history (member_id, item_id, quantity, points_used, created_at) 
                  VALUES ($memberId, $itemId, $quantity, $totalPointsRequired, NOW())";
    $conn->query($sqlInsert);

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Poin tidak cukup']);
}

$conn->close();
?>
