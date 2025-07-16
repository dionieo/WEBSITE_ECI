<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include 'php/koneksi.php';
include 'php/function.php';
$accounts = getAllAccounts();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Input Transaksi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            background: #fff;
            color: #1a1a1a;
            padding: 1rem 0;
            filter: drop-shadow(0 2px 12px rgba(0,0,0,0.07));
            position: sticky;
            top: 0;
        }
        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 900px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        .navbar-brand {
            font-size: 1.3rem;
            font-weight: bold;
            text-decoration: none;
            color: #fff;
        }

        .navbar-brand img {
            height: 100px;
            width: auto;
        }

        .logout-btn {
            background: #68aae3;
            color: #fff;
            border: none;
            padding: 0.5rem 1.2rem;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            transition: background 0.2s;
        }
        .logout-btn:hover {
            background: #8dbbe2;
        }

        @media (max-width: 768px) {
            .navbar-brand img{
                height: 80px;
                width: auto;
            }
        }
    </style>
</head>
<body class="bg-light">
    <div class="navbar">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="./img/icon.png" alt=""></a>
            <a href="index.php" class="logout-btn">Dashboard</a>
        </div>
    </div>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="mb-4 text-center">Input Transaksi</h3>
                        <form method="POST" action="php/transaksi.php">
                            <div class="mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <input type="text" name="description" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis</label>
                                <select name="type" class="form-select" required>
                                    <option value="debit">Debit (Pemasukan)</option>
                                    <option value="kredit">Kredit (Pengeluaran)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jumlah</label>
                                <input type="number" name="amount" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Akun</label>
                                <select name="account_id" class="form-select" required>
                                    <?php foreach ($accounts as $acc): ?>
                                        <option value="<?= $acc['id'] ?>"><?= $acc['account_code'] ?> - <?= $acc['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" name="submit" class="btn btn-success w-100">Simpan Transaksi</button>
                        </form>
                        <div class="mt-3 text-center">
                            </div>
                        <a href="index.php" class="btn btn-secondary">Kembali ke Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>