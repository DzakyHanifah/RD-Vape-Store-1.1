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

$response = ["success" => false];

if (isset($data['name']) && !empty($data['name'])) {
    $name = $conn->real_escape_string($data['name']);
    $phone = isset($data['phone']) ? $conn->real_escape_string($data['phone']) : null;
    $email = isset($data['email']) ? $conn->real_escape_string($data['email']) : null;

    // Query untuk menambahkan member baru
    $sql = "INSERT INTO members (name, phone, email, points, total_points, created_at) VALUES (?, ?, ?, 0, 0, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $phone, $email);

    if ($stmt->execute()) {
        $response["success"] = true;
    }

    $stmt->close();
}

// Mengembalikan response JSON
header('Content-Type: application/json');
echo json_encode($response);

// Menutup koneksi
$conn->close();
?>
