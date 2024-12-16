<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kasir_db";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mendapatkan data dari request POST
$data = json_decode(file_get_contents('php://input'), true);

$response = ["success" => false, "price" => 0];

if (isset($data['transactionId'])) {
    $transactionId = $conn->real_escape_string($data['transactionId']);

    // Query untuk mendapatkan harga transaksi berdasarkan ID transaksi
    $sql = "SELECT total FROM transactions WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $transactionId);
    $stmt->execute();
    $stmt->bind_result($totalPrice);
    
    if ($stmt->fetch()) {
        $response["success"] = true;
        $response["price"] = $totalPrice;  // Mengembalikan harga transaksi
    }

    $stmt->close();
}

// Mengembalikan response JSON
header('Content-Type: application/json');
echo json_encode($response);

// Menutup koneksi
$conn->close();
?>
