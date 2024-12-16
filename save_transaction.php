<?php
$conn = new mysqli("localhost", "root", "", "kasir_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart = $_POST['cart'];
    $total = $_POST['total'];
    $paymentMethod = $_POST['paymentMethod'];
    $cashGiven = isset($_POST['cashGiven']) ? $_POST['cashGiven'] : null;
    $change = isset($_POST['change']) ? $_POST['change'] : null;

    // Validasi stok barang
    foreach ($cart as $item) {
        $itemId = $item['itemId'];
        $itemQty = $item['itemQty'];

        $itemQuery = $conn->query("SELECT stock FROM items WHERE id = $itemId");
        $itemData = $itemQuery->fetch_assoc();

        if (!$itemData || $itemData['stock'] < $itemQty) {
            echo json_encode([
                'success' => false,
                'message' => "Stok untuk barang dengan ID $itemId tidak mencukupi!"
            ]);
            exit;
        }
    }

    // Mulai transaksi
    $conn->begin_transaction();

    try {
        // Simpan transaksi
        /*$query = "INSERT INTO transactions (total, payment_method, cash_given, change) 
                  VALUES ('$total', '$paymentMethod', '$cashGiven', '$change')";*/
        $query = "INSERT INTO transactions (total, payment_method, cash_given, change_amount) 
                  VALUES ('$total', '$paymentMethod', '$cashGiven', '$change')";
        
        
        if (!$conn->query($query)) {
            throw new Exception("Error: " . $conn->error);
        }
        $transactionId = $conn->insert_id;

        // Simpan detail transaksi dan kurangi stok
        foreach ($cart as $item) {
            $itemId = $item['itemId'];
            $itemQty = $item['itemQty'];
            $subtotal = $item['subtotal'];

            if (!$conn->query("UPDATE items SET stock = stock - $itemQty WHERE id = $itemId")) {
                throw new Exception("Error updating stock for item $itemId: " . $conn->error);
            }

            if (!$conn->query("INSERT INTO transaction_details (transaction_id, item_id, quantity, subtotal) 
                               VALUES ('$transactionId', '$itemId', '$itemQty', '$subtotal')")) {
                throw new Exception("Error inserting transaction details for item $itemId: " . $conn->error);
            }
        }

        // Commit transaction
        $conn->commit();

        echo json_encode([
            'success' => true,
            'transactionId' => $transactionId,
            'message' => 'Transaksi berhasil disimpan!'
        ]);
    } catch (Exception $e) {
        $conn->rollback();  // Rollback jika terjadi error
        echo json_encode([
            'success' => false,
            'message' => 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage()
        ]);
    }
}
?>
