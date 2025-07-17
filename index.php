<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil username dengan aman
$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Pengguna';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            background-color: #2d3436;
            background-image: linear-gradient(315deg, #2d3436 0%, #000000 74%);
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #bdc3c7;
        }

        .navbar {
            background: #3b4144;
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid #4a5154;
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0.5rem 1.5rem;
        }

        .navbar-brand img {
            height: 60px;
            width: auto;
            vertical-align: middle;
        }

        .logout-btn {
            background: #d62828;
            color: #fff;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            transition: opacity 0.3s ease;
        }

        .logout-btn:hover {
            opacity: 0.85;
        }

        .container-main {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 1.5rem;
        }

        .welcome {
            font-size: 1.8rem;
            margin-bottom: 2rem;
            text-align: center;
            font-weight: 300;
        }

        .welcome strong {
            color: #ffffff;
            font-weight: 600;
        }
        
        .dashboard-grid {
            display: grid;
            gap: 1.5rem;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); /* Kolom grid responsif */
        }

        .card-link {
            display: flex; /* Mengubah layout internal menjadi flexbox */
            align-items: center;
            padding: 1.5rem;
            text-decoration: none;
            border-radius: 12px;
            background-color: #3b4144;
            border: 1px solid #4a5154;
            transition: all 0.2s ease-in-out;
            min-height: 90px;
        }

        .card-link:hover {
            transform: translateY(-5px);
            border-color: #1da1f2;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
        }

        .card-icon {
            flex-shrink: 0;
            width: 50px;
            height: 50px;
            margin-right: 1.5rem;
            color: #1da1f2; /* Warna ikon */
        }

        .card-content h3 {
            margin: 0 0 0.25rem 0;
            color: #ffffff;
            font-size: 1.2rem;
        }

        .card-content p {
            margin: 0;
            color: #bdc3c7; /* Warna teks deskripsi */
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .welcome {
                font-size: 1.5rem;
            }
            .navbar-brand img {
                height: 50px;
            }
            .dashboard-grid {
                grid-template-columns: 1fr; /* Satu kolom di layar kecil */
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="./img/icon.png" alt="Logo">
            </a>
            <a href="logout.php" class="logout-btn" onclick="return confirm('Apakah Anda yakin ingin logout?');">Logout</a>
        </div>
    </nav>

    <main class="container-main">
        <h1 class="welcome">
            Selamat datang, <strong><?= $username ?></strong>!
        </h1>
        
        <div class="dashboard-grid">
            <a href="input-transaksi.php" class="card-link">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                </div>
                <div class="card-content">
                    <h3>Input Transaksi</h3>
                    <p>Catat pemasukan dan pengeluaran baru.</p>
                </div>
            </a>
            
            <a href="laporan.php" class="card-link">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path d="M5 9.2h3V19H5zM10.6 5h2.8v14h-2.8zm5.6 8H19v6h-2.8z"/></svg>
                </div>
                <div class="card-content">
                    <h3>Laporan Keuangan</h3>
                    <p>Lihat ringkasan pendapatan dan pengeluaran.</p>
                </div>
            </a>

            <a href="jurnal.php" class="card-link">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path d="M3 18.5V5h3v13.5c0 .8.7 1.5 1.5 1.5s1.5-.7 1.5-1.5V5H13v13.5c0 .8.7 1.5 1.5 1.5s1.5-.7 1.5-1.5V5h3v13a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3z"/></svg>
                </div>
                <div class="card-content">
                    <h3>Jurnal Umum</h3>
                    <p>Tinjau semua catatan transaksi secara kronologis.</p>
                </div>
            </a>

            <a href="neraca-detail.php" class="card-link">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path d="M21.49 10.75-2.2 5.56l1-3.81 22.69 5.19zM2.81 7.4L1 11.21l10.51 2.4-1.7-6.21zm20.28.02-9.51-2.15-1.7 6.21L23.09 9zM12 15.19l-9-2.07L1 17l11 2.54L23 17l-2.09-3.88z"/></svg>
                </div>
                <div class="card-content">
                    <h3>Neraca</h3>
                    <p>Analisis posisi aset, liabilitas, dan ekuitas.</p>
                </div>
            </a>

            <a href="buku-besar.php" class="card-link">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/></svg>
                </div>
                <div class="card-content">
                    <h3>Buku Besar</h3>
                    <p>Rincian transaksi per akun individual.</p>
                </div>
            </a>

        </div>
    </main>
</body>
</html>