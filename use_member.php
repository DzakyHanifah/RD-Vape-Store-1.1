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

$response = ["success" => false, "message" => ""];

if (isset($data['memberId'], $data['transactionId'], $data['pointsEarned'])) {
    $memberId = $conn->real_escape_string($data['memberId']);
    $transactionId = $conn->real_escape_string($data['transactionId']);
    $pointsEarned = $conn->real_escape_string($data['pointsEarned']);

    // Periksa apakah ID transaksi sudah digunakan
    $checkSql = "SELECT COUNT(*) AS count FROM point_exchange_history WHERE transaction_id = ?";
    $stmtCheck = $conn->prepare($checkSql);
    $stmtCheck->bind_param("i", $transactionId);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();
    $rowCheck = $resultCheck->fetch_assoc();
    $stmtCheck->close();

    if ($rowCheck['count'] > 0) {
        // ID transaksi sudah digunakan
        $response["message"] = "ID transaksi sudah digunakan.";
    } else {
        // Update poin member
        $sql = "UPDATE members SET points = points + ?, total_points = total_points + ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ddi", $pointsEarned, $pointsEarned, $memberId);

        if ($stmt->execute()) {
            // Simpan riwayat penukaran poin
            $sqlHistory = "INSERT INTO point_exchange_history (member_id, transaction_id, points_earned, created_at) 
                           VALUES (?, ?, ?, NOW())";
            $stmtHistory = $conn->prepare($sqlHistory);
            $stmtHistory->bind_param("iid", $memberId, $transactionId, $pointsEarned);
            $stmtHistory->execute();

            $response["success"] = true;
            $response["message"] = "Poin berhasil ditambahkan.";
        }

        $stmt->close();
    }
}

// Mengembalikan response JSON
header('Content-Type: application/json');
echo json_encode($response);

// Menutup koneksi
$conn->close();
?>
