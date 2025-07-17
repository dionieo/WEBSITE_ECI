<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Pengguna';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="./img/newicon.png" type="image/x-icon">
    <style>
        :root {
            --sidebar-width: 80px; 
            --bg-dark: #2d3436;
            --bg-dark-gradient: linear-gradient(315deg, #2d3436 0%, #000000 74%);
            --bg-element: #3b4144;
            --border-color: #4a5154;
            --text-primary: #ffffff;
            --text-secondary: #bdc3c7;
            --accent-color: #1da1f2;
            --danger-color: #d62828;
            --transition-speed: 0.5s; /* Kecepatan transisi */
        }

        /* Reset & Global Styles */
        * { box-sizing: border-box; }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0;
            background-color: var(--bg-dark);
            background-image: var(--bg-dark-gradient);
            color: var(--text-secondary);
            /* CSS untuk Transisi */
            opacity: 1;
            transition: opacity var(--transition-speed) ease-out;
        }
        /* Class untuk fade out */
        body.fade-out {
            opacity: 0;
        }

        /* Main Layout */
        .page-container { display: flex; height: 100vh; }
        .main-content {
            flex-grow: 1; padding: 2rem; overflow-y: auto;
            /* Animasi fade in */
            animation: fadeIn var(--transition-speed) ease-in-out;
        }
        
        /* Keyframes untuk animasi fade-in */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* (Sisa CSS lainnya tetap sama seperti sebelumnya) */
        .sidebar { width: var(--sidebar-width); background-color: var(--bg-element); border-right: 1px solid var(--border-color); display: flex; flex-direction: column; padding: 1rem 0; transition: transform 0.3s ease-in-out; flex-shrink: 0; }
        .sidebar-header { text-align: center; padding: 0.5rem; margin-bottom: 1.5rem; }
        .sidebar-header img { max-width: 45px; height: auto; }
        .sidebar-nav ul { list-style: none; padding: 0; margin: 0; }
        .sidebar-nav a { display: flex; align-items: center; justify-content: center; height: 50px; color: var(--text-secondary); text-decoration: none; margin: 0.5rem auto; width: 50px; border-radius: 10px; transition: background-color 0.2s, color 0.2s; position: relative; }
        .sidebar-nav a:hover { background-color: rgba(255, 255, 255, 0.05); color: var(--text-primary); }
        .sidebar-nav a.active { background-color: var(--accent-color); color: var(--text-primary); }
        .sidebar-nav .icon { width: 24px; height: 24px; }
        .sidebar-nav a[data-tooltip]::after { content: attr(data-tooltip); position: absolute; left: calc(var(--sidebar-width) - 10px); top: 50%; transform: translateY(-50%); padding: 0.5rem 1rem; border-radius: 6px; background: #222; color: #fff; font-size: 0.9rem; white-space: nowrap; z-index: 10; opacity: 0; visibility: hidden; transition: opacity 0.2s ease; pointer-events: none; }
        .sidebar-nav a[data-tooltip]:hover::after { opacity: 1; visibility: visible; transition-delay: 0.3s; }
        .sidebar-footer { margin-top: auto; padding: 1rem 0; }
        .logout-btn { display: flex; align-items: center; justify-content: center; height: 50px; width: 50px; margin: 0 auto; border: none; background: none; color: var(--danger-color); border-radius: 10px; cursor: pointer; transition: background-color 0.2s ease; position: relative; }
        .logout-btn:hover { background-color: rgba(214, 40, 40, 0.15); }
        .logout-btn .icon { width: 24px; height: 24px; }
        .logout-btn[data-tooltip]::after { content: attr(data-tooltip); position: absolute; left: calc(var(--sidebar-width) - 10px); top: 50%; transform: translateY(-50%); padding: 0.5rem 1rem; border-radius: 6px; background: #222; color: #fff; font-size: 0.9rem; white-space: nowrap; z-index: 10; opacity: 0; visibility: hidden; transition: opacity 0.2s ease; pointer-events: none; }
        .logout-btn[data-tooltip]:hover::after { opacity: 1; visibility: visible; transition-delay: 0.3s; }
        .welcome { font-size: 1.8rem; margin-bottom: 1rem; font-weight: 300; }
        .welcome strong { color: var(--text-primary); font-weight: 600; }
        .primary-action-card { display: flex; align-items: center; width: 100%; padding: 1.5rem 2rem; margin-top: 1.5rem; margin-bottom: 2.5rem; background-color: var(--accent-color); color: var(--text-primary); border-radius: 12px; text-decoration: none; transition: all 0.2s ease; }
        .primary-action-card:hover { transform: scale(1.02); box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3); }
        .primary-action-card .card-icon { width: 40px; height: 40px; margin-right: 1.5rem; color: var(--text-primary); }
        .primary-action-card .card-content h3 { margin: 0; font-size: 1.5rem; font-weight: 600; }
        .section-title { font-size: 1.2rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border-color); }
        .dashboard-grid { display: grid; gap: 1.5rem; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); }
        .card-link { display: flex; align-items: center; padding: 1.5rem; text-decoration: none; border-radius: 12px; background-color: var(--bg-element); border: 1px solid var(--border-color); transition: all 0.2s ease-in-out; min-height: 90px; }
        .card-link:hover { transform: translateY(-5px); border-color: var(--accent-color); box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25); }
        .card-link .card-icon { flex-shrink: 0; width: 40px; height: 40px; margin-right: 1.5rem; color: var(--accent-color); }
        .card-link .card-content h3 { margin: 0 0 0.25rem 0; color: var(--text-primary); font-size: 1.1rem; }
        .card-link .card-content p { margin: 0; font-size: 0.9rem; color: var(--text-secondary); }
        .mobile-header { display: none; }
        .menu-toggle { background: none; border: none; color: var(--text-primary); font-size: 1.8rem; cursor: pointer; padding: 0.5rem; }
        .overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1001; }
        @media (max-width: 768px) {
            .sidebar { position: fixed; top: 0; left: 0; height: 100%; z-index: 1002; transform: translateX(-100%); }
            .main-content { padding: 1rem; margin-top: 60px; }
            .mobile-header { display: flex; align-items: center; padding: 0 1rem; position: fixed; top: 0; left: 0; right: 0; height: 60px; background-color: var(--bg-element); z-index: 1000; border-bottom: 1px solid var(--border-color); }
            body.sidebar-open .sidebar { transform: translateX(0); }
            body.sidebar-open .overlay { display: block; }
            .sidebar-nav a[data-tooltip]::after, .logout-btn[data-tooltip]::after { display: none; }
        }
    </style>
</head>
<body>

    <div class="page-container">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="index.php"><img src="./img/newicon.png" alt="Logo"></a>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="index.php" class="active" data-tooltip="Dashboard"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg></span></a></li>
                    <li><a href="input-transaksi.php" data-tooltip="Input Transaksi"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg></span></a></li>
                    <li><a href="jurnal.php" data-tooltip="Jurnal Umum"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M3 18.5V5h3v13.5c0 .8.7 1.5 1.5 1.5s1.5-.7 1.5-1.5V5H13v13.5c0 .8.7 1.5 1.5 1.5s1.5-.7 1.5-1.5V5h3v13a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3z"/></svg></span></a></li>
                    <li><a href="buku-besar.php" data-tooltip="Buku Besar"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/></svg></span></a></li>
                    <li><a href="laporan.php" data-tooltip="Laporan Keuangan"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M5 9.2h3V19H5zM10.6 5h2.8v14h-2.8zm5.6 8H19v6h-2.8z"/></svg></span></a></li>
                </ul>
            </nav>
            <div class="sidebar-footer">
                <button class="logout-btn" data-tooltip="Logout" onclick="if(confirm('Apakah Anda yakin ingin logout?')) window.location.href='logout.php';">
                    <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg></span>
                </button>
            </div>
        </aside>

        <div class="mobile-header"><button class="menu-toggle" id="menu-toggle">☰</button></div>
        <div class="overlay" id="overlay"></div>
        <main class="main-content">
            <h1 class="welcome">Selamat datang, <strong><?= $username ?></strong>!</h1>
            <a href="input-transaksi.php" class="primary-action-card">
                <div class="card-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg></div>
                <div class="card-content"><h3>Input Transaksi Baru</h3></div>
            </a>
            <h2 class="section-title">Menu Lainnya</h2>
            <div class="dashboard-grid">
                <a href="laporan.php" class="card-link">
                    <div class="card-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path d="M5 9.2h3V19H5zM10.6 5h2.8v14h-2.8zm5.6 8H19v6h-2.8z"/></svg></div>
                    <div class="card-content"><h3>Laporan Keuangan</h3><p>Lihat ringkasan pendapatan dan pengeluaran.</p></div>
                </a>
                <a href="jurnal.php" class="card-link">
                    <div class="card-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path d="M3 18.5V5h3v13.5c0 .8.7 1.5 1.5 1.5s1.5-.7 1.5-1.5V5H13v13.5c0 .8.7 1.5 1.5 1.5s1.5-.7 1.5-1.5V5h3v13a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3z"/></svg></div>
                    <div class="card-content"><h3>Jurnal Umum</h3><p>Tinjau semua catatan transaksi.</p></div>
                </a>
                <a href="neraca-detail.php" class="card-link">
                    <div class="card-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path d="M21.49 10.75-2.2 5.56l1-3.81 22.69 5.19zM2.81 7.4L1 11.21l10.51 2.4-1.7-6.21zm20.28.02-9.51-2.15-1.7 6.21L23.09 9zM12 15.19l-9-2.07L1 17l11 2.54L23 17l-2.09-3.88z"/></svg></div>
                    <div class="card-content"><h3>Neraca</h3><p>Analisis posisi aset dan liabilitas.</p></div>
                </a>
                <a href="buku-besar.php" class="card-link">
                    <div class="card-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/></svg></div>
                    <div class="card-content"><h3>Buku Besar</h3><p>Rincian transaksi per akun.</p></div>
                </a>
            </div>
        </main>
    </div>

    <script>
        // Mobile sidebar toggle
        document.addEventListener('DOMContentLoaded', function () {
            const menuToggle = document.getElementById('menu-toggle');
            const overlay = document.getElementById('overlay');
            if(menuToggle) {
                menuToggle.addEventListener('click', function () {
                    document.body.classList.toggle('sidebar-open');
                });
            }
            if(overlay) {
                overlay.addEventListener('click', function () {
                    document.body.classList.remove('sidebar-open');
                });
            }
        });

        // Page transition script
        window.addEventListener('load', () => {
            const links = document.querySelectorAll('a');
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    // Hanya jalankan untuk link internal, bukan link eksternal atau link #
                    if (href && href.startsWith('/') || href.includes('.php')) {
                        e.preventDefault();
                        document.body.classList.add('fade-out');
                        setTimeout(() => {
                            window.location.href = href;
                        }, 500); // Sesuaikan dengan durasi transisi di CSS
                    }
                });
            });
        });
    </script>
</body>
</html>