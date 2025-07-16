<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include 'php/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    $cek = $conn->prepare("SELECT * FROM transactions WHERE id = ? AND user_id = ?");
    $cek->bind_param("ii", $id, $user_id);
    $cek->execute();
    $res = $cek->get_result();

    if ($res->num_rows > 0) {
        $conn->query("DELETE FROM transactions WHERE id = $id");
        header("Location: jurnal.php?deleted=1");
    } else {
        echo "Transaksi tidak ditemukan atau bukan milik Anda.";
    }
} else {
    header("Location: jurnal.php");
}
?>
