<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include 'php/koneksi.php';
include 'php/function.php';
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=jurnal-umum.xls");

$jurnal = getJurnalUmum();
echo "<table border='1'>";
echo    "<tr>
            <th>Tanggal</th>
            <th>Deskripsi</th>
            <th>Akun</th>
            <th>Debit</th>
            <th>Kredit</th>
        </tr>";
foreach ($jurnal as $row) {
    echo "<tr>";
    echo "<td>".htmlspecialchars($row['date'])."</td>";
    echo "<td>".htmlspecialchars($row['description'])."</td>";
    echo "<td>".htmlspecialchars($row['account_code'])." - ".htmlspecialchars($row['account_name'])."</td>";
    echo "<td>".($row['type']=='debit' ? $row['amount'] : '')."</td>";
    echo "<td>".($row['type']=='kredit' ? $row['amount'] : '')."</td>";
    echo "</tr>";
}
echo "</table>";
exit;
?>