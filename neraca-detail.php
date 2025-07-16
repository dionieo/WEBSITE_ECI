<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include 'php/koneksi.php';
include 'php/function.php';

$neraca_detail = getNeracaDetail();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Neraca Lengkap</title>
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
        <h2 class="mb-4 text-center">Neraca Detail - <?= htmlspecialchars($_SESSION['username']) ?></h2>
        <div class="row justify-content-center">
            <div class="col-12 col-md-10">
                <?php foreach (['aset', 'liabilitas', 'modal'] as $tipe): ?>
                    <div class="card shadow-sm mb-4">
                        <div class="card-header <?= $tipe === 'aset' ? 'bg-success' : ($tipe === 'liabilitas' ? 'bg-danger' : 'bg-info') ?> text-white">
                            <h5 class="mb-0"><?= ucfirst($tipe) ?></h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Kode Akun</th>
                                            <th>Nama Akun</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($neraca_detail[$tipe] as $row): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row['account_code']) ?></td>
                                                <td><?= htmlspecialchars($row['name']) ?></td>
                                                <td class="text-end">Rp <?= number_format($row['total']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="text-center mt-4">
                    <button onclick="window.print()" class="btn btn-outline-primary me-2">Print</button>
                    <a href="export-neraca.php" class="btn btn-outline-success me-2">Export Excel</a>
                    <a href="index.php" class="btn btn-secondary">Kembali ke Dashboard</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
