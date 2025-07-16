<?php
session_start();
include 'koneksi.php';
if (isset($_POST['submit'])) {
    $date = $_POST['date'];
    $desc = $_POST['description'];
    $type = $_POST['type'];
    $amount = $_POST['amount'];
    $account_id = $_POST['account_id'];
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("INSERT INTO transactions (date, description, type, amount, account_id, user_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdis", $date, $desc, $type, $amount, $account_id, $user_id);
    if ($stmt->execute()) {
        header("Location: ../input-transaksi.php?success=1");
        exit;
    } else {
        echo "Gagal simpan transaksi.";
    }
}
?>