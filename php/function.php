<?php
include 'koneksi.php';
function getAllAccounts() {
    global $conn;
    $result = $conn->query("SELECT * FROM accounts ORDER BY account_code ASC");
    return $result->fetch_all(MYSQLI_ASSOC);
}
function getLaporanLabaRugi() {
    global $conn;
    $user_id = $_SESSION['user_id'];

    $pendapatan = $conn->query("SELECT SUM(amount) as total FROM transactions 
        JOIN accounts ON transactions.account_id = accounts.id 
        WHERE accounts.type = 'pendapatan' AND transactions.user_id = $user_id")->fetch_assoc()['total'] ?? 0;

    $beban = $conn->query("SELECT SUM(amount) as total FROM transactions 
        JOIN accounts ON transactions.account_id = accounts.id 
        WHERE accounts.type = 'beban' AND transactions.user_id = $user_id")->fetch_assoc()['total'] ?? 0;

    return [
        'pendapatan' => $pendapatan,
        'beban' => $beban
    ];
}
function getNeraca() {
    global $conn;
    $user_id = $_SESSION['user_id'];

    $aset = $conn->query("SELECT SUM(amount) as total FROM transactions 
        JOIN accounts ON transactions.account_id = accounts.id 
        WHERE accounts.type = 'aset' AND transactions.user_id = $user_id")->fetch_assoc()['total'] ?? 0;

    $liabilitas = $conn->query("SELECT SUM(amount) as total FROM transactions 
        JOIN accounts ON transactions.account_id = accounts.id 
        WHERE accounts.type = 'liabilitas' AND transactions.user_id = $user_id")->fetch_assoc()['total'] ?? 0;

    $modal = $conn->query("SELECT SUM(amount) as total FROM transactions 
        JOIN accounts ON transactions.account_id = accounts.id 
        WHERE accounts.type = 'modal' AND transactions.user_id = $user_id")->fetch_assoc()['total'] ?? 0;

    return [
        'aset' => $aset,
        'liabilitas' => $liabilitas,
        'modal' => $modal
    ];
}

function getJurnalUmum() {
    global $conn;
    $user_id = $_SESSION['user_id'];

    $result = $conn->query("
        SELECT t.id, t.date, t.description, a.account_code, a.name AS account_name, t.type, t.amount
        FROM transactions t
        JOIN accounts a ON t.account_id = a.id
        WHERE t.user_id = $user_id
        ORDER BY t.date ASC
    ");

    return $result->fetch_all(MYSQLI_ASSOC);
}

function getNeracaDetail() {
    global $conn;
    $user_id = $_SESSION['user_id'];
    $jenis = ['aset', 'liabilitas', 'modal'];
    $data = [];

    foreach ($jenis as $tipe) {
        $query = $conn->query("
            SELECT a.account_code, a.name, SUM(t.amount) AS total
            FROM transactions t
            JOIN accounts a ON t.account_id = a.id
            WHERE a.type = '$tipe' AND t.user_id = $user_id
            GROUP BY a.id
        ");
        $data[$tipe] = $query->fetch_all(MYSQLI_ASSOC);
    }

    return $data;
}

function getBukuBesar() {
    global $conn;
    $user_id = $_SESSION['user_id'];

    $result = $conn->query("
        SELECT t.date, t.description, t.amount, t.type, a.name AS account_name
        FROM transactions t
        JOIN accounts a ON t.account_id = a.id
        WHERE t.user_id = $user_id
        ORDER BY a.id, t.date ASC
    ");

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $akun = $row['account_name'];
        if (!isset($data[$akun])) {
            $data[$akun] = [];
        }
        $data[$akun][] = $row;
    }

    return $data;
}

?>