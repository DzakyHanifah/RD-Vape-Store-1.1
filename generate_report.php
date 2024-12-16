<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "kasir_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil opsi yang dipilih dari parameter GET
$reportType = isset($_GET['report_type']) ? $_GET['report_type'] : 'weekly';

// Tentukan query berdasarkan tipe laporan
switch ($reportType) {
    case 'weekly':
        $timeFilter = "WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
        $title = "LAPORAN PENJUALAN MINGGUAN";
        $groupBy = 'DATE(created_at)';
        break;
    case 'monthly':
        $timeFilter = "WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
        $title = "LAPORAN PENJUALAN BULANAN";
        $groupBy = 'MONTH(created_at), DATE(created_at)';
        break;
    case 'yearly':
        $timeFilter = "WHERE YEAR(created_at) = YEAR(CURDATE())";
        $title = "LAPORAN PENJUALAN TAHUNAN";
        $groupBy = 'YEAR(created_at), MONTH(created_at)';
        break;
    default:
        die("Invalid report type selected.");
}

// Query untuk mendapatkan data penjualan
$query = $conn->query("SELECT DATE(created_at) AS tanggal, TIME(created_at) AS waktu, i.name AS barang, td.quantity AS jumlah, i.price AS harga_jual, t.payment_method AS pembayaran, (td.quantity * i.price) AS total FROM transaction_details td JOIN items i ON td.item_id = i.id JOIN transactions t ON td.transaction_id = t.id $timeFilter ORDER BY $groupBy");

if (!$query->num_rows) {
    die("Tidak ada data untuk periode yang dipilih.");
}

// Siapkan data untuk laporan
$rows = [];
$total_penjualan = 0;
$currentGroup = null;
$colorIndex = 0;
$colors = ['#f2f2f2', '#e6f7ff', '#eaf2d7'];

while ($row = $query->fetch_assoc()) {
    $total_penjualan += $row['total'];
    $rows[] = $row;
}

// Header untuk export Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment;filename=Laporan_Penjualan_{$reportType}.xls");
header("Cache-Control: max-age=0");

// Buat tabel untuk laporan
echo "<table border='1' style='border-collapse:collapse; width:100%; font-family:Arial, sans-serif; text-align:center; position:relative;'>
        <thead>
            <tr>
                <th colspan='7' style='font-size:24px; font-weight:bold; background-color:#4CAF50; color:white;'>$title</th>
            </tr>
            <tr>
                <th colspan='7' style='font-size:16px;'>Tanggal: " . date("d F Y") . "</th>
            </tr>
            <tr style='background-color:#d9edf7;'>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Harga Jual</th>
                <th>Pembayaran</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody style='background: url(./asset/Logo No Bg.PNG) no-repeat center; background-size: contain; opacity: 0.1;'>";

// Isi data penjualan
foreach ($rows as $row) {
    $groupKey = ($reportType === 'weekly') ? $row['tanggal'] : (($reportType === 'monthly') ? date('F', strtotime($row['tanggal'])) : date('Y', strtotime($row['tanggal'])));

    if ($currentGroup !== $groupKey) {
        $currentGroup = $groupKey;
        $colorIndex = ($colorIndex + 1) % count($colors);
    }

    echo "<tr style='background-color: {$colors[$colorIndex]}'>
            <td>{$row['tanggal']}</td>
            <td>{$row['waktu']}</td>
            <td>{$row['barang']}</td>
            <td>{$row['jumlah']}</td>
            <td>Rp" . number_format($row['harga_jual'], 0, ',', '.') . "</td>
            <td>{$row['pembayaran']}</td>
            <td>Rp" . number_format($row['total'], 0, ',', '.') . "</td>
          </tr>";
}

// Total Penjualan
echo "<tr style='font-weight:bold; background-color:#f9f9f9;'>
        <td colspan='6' style='text-align:right;'>TOTAL PENJUALAN</td>
        <td>Rp" . number_format($total_penjualan, 0, ',', '.') . "</td>
      </tr>";

echo "</tbody></table>";
?>