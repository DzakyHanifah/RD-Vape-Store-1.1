<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "kasir_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get transaction ID from URL
$transactionId = $_GET['id'];
if (!$transactionId) {
    die("Transaction ID is required.");
}

// Fetch transaction details
$transactionQuery = $conn->query("SELECT * FROM transactions WHERE id = $transactionId");
$transaction = $transactionQuery->fetch_assoc();
if (!$transaction) {
    die("Transaction not found.");
}

// Fetch transaction items
$itemsQuery = $conn->query("
    SELECT i.name, td.quantity, td.subtotal 
    FROM transaction_details td
    JOIN items i ON td.item_id = i.id
    WHERE td.transaction_id = $transactionId
");

if ($itemsQuery->num_rows === 0) {
    die("No items found for this transaction.");
}

// Calculate the change if not already calculated in the database
$cashGiven = $transaction['cash_given'];
$totalAmount = $transaction['total'];
$change = $cashGiven - $totalAmount; // Calculate change if not already in the database

// Generate HTML content
$html = "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Struk Transaksi</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body Styling */
        body {
            font-family: Arial, sans-serif;
            background: url('./asset/Logo No Bg.PNG') no-repeat center center/cover;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            color: #333;
        }

        /* Main Container */
        .receipt-container {
            background-color: white;
            border: 1px solid #333;
            padding: 15px;
            border-radius: 10px;
            width: 400px;
            margin: 0 auto;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Header Section */
        h1 {
            text-align: center;
            margin-bottom: 10px;
            color: #555;
        }

        /* Transaction Info */
        .transaction-info {
            margin: 10px 0;
            text-align: center;
            font-size: 14px;
        }

        /* Item Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        table th,
        table td {
            border: 1px solid #555;
            padding: 8px;
            text-align: center;
            font-size: 14px;
        }

        table th {
            background-color: #333;
            color: white;
        }

        /* Totals */
        .summary {
            margin: 10px 0;
            font-size: 16px;
            text-align: right;
            font-weight: bold;
        }

        /* Bottom Notes Section */
        .footer {
            margin-top: 15px;
            text-align: center;
            font-size: 12px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class='receipt-container'>
        <h1>Bukti Transaksi</h1>
        <div class='transaction-info'>
            <p><strong>Transaction ID:</strong> {$transaction['id']}</p>
            <p><strong>Tanggal:</strong> {$transaction['created_at']}</p>
            <p><strong>Metode Pembayaran:</strong> {$transaction['payment_method']}</p>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>";

while ($item = $itemsQuery->fetch_assoc()) {
    $html .= "
                <tr>
                    <td>{$item['name']}</td>
                    <td>{$item['quantity']}</td>
                    <td>Rp " . number_format($item['subtotal'], 2, ',', '.') . "</td>
                </tr>";
}

$html .= "
            </tbody>
        </table>
        <div class='summary'>
            <p><strong>Total:</strong> Rp " . number_format($transaction['total'], 2, ',', '.') . "</p>
            <p><strong>Nominal Diberikan:</strong> Rp " . number_format($cashGiven, 2, ',', '.') . "</p>
            <p><strong>Kembalian:</strong> Rp " . number_format($change, 2, ',', '.') . "</p>
        </div>
        <div class='footer'>
            Terima kasih telah berbelanja bersama kami!
        </div>
    </div>
</body>
</html>
";

// Set headers for download
header("Content-Type: application/x-download");
header("Content-Disposition: attachment; filename=Transaction_{$transactionId}.html");
echo $html;
?>
