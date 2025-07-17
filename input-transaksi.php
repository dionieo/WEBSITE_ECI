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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Transaksi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        /* Salin seluruh blok <style> dari kode index.php di atas ke sini */
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
            --transition-speed: 0.5s;
        }
        * { box-sizing: border-box; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; margin: 0; background-color: var(--bg-dark); background-image: var(--bg-dark-gradient); color: var(--text-secondary); opacity: 1; transition: opacity var(--transition-speed) ease-out; }
        body.fade-out { opacity: 0; }
        .page-container { display: flex; height: 100vh; }
        .main-content { flex-grow: 1; padding: 2rem; overflow-y: auto; animation: fadeIn var(--transition-speed) ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
        
        /* CSS Sidebar & Lainnya... (salin dari index.php) */
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
        .mobile-header { display: none; }
        .menu-toggle { background: none; border: none; color: var(--text-primary); font-size: 1.8rem; cursor: pointer; padding: 0.5rem; }
        .overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1001; }
        @media (max-width: 768px) { .sidebar { position: fixed; top: 0; left: 0; height: 100%; z-index: 1002; transform: translateX(-100%); } .main-content { padding: 1rem; margin-top: 60px; } .mobile-header { display: flex; align-items: center; padding: 0 1rem; position: fixed; top: 0; left: 0; right: 0; height: 60px; background-color: var(--bg-element); z-index: 1000; border-bottom: 1px solid var(--border-color); } body.sidebar-open .sidebar { transform: translateX(0); } body.sidebar-open .overlay { display: block; } .sidebar-nav a[data-tooltip]::after, .logout-btn[data-tooltip]::after { display: none; } }
        
        /* Styling khusus untuk halaman ini */
        .page-title { color: #ffffff; text-align: center; margin-bottom: 2rem; font-weight: 300; font-size: 2.2rem; }
        .form-card { background-color: var(--bg-element); border: 1px solid var(--border-color); border-radius: 12px; padding: 2rem; max-width: 600px; margin: 0 auto; }
        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-primary); }
        .form-control { width: 100%; display: block; background-color: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 8px; padding: 0.75rem 1rem; box-sizing: border-box; color: var(--text-primary); font-size: 1rem; }
        .form-control:focus { outline: none; border-color: var(--accent-color); }
        .btn-theme { display: inline-block; padding: 0.8rem 1.5rem; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; text-decoration: none; transition: all 0.2s ease; margin-top: 1rem; width: 100%; font-size: 1rem; }
        .btn-submit { background-color: var(--accent-color); color: #fff; }
        .btn-submit:hover { opacity: 0.9; }

    </style>
</head>
<body>
    <div class="page-container">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="index.php"><img src="./img/icon.png" alt="Logo"></a>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="index.php" data-tooltip="Dashboard"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg></span></a></li>
                    <li><a href="input-transaksi.php" class="active" data-tooltip="Input Transaksi"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg></span></a></li>
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
            <h1 class="page-title">Input Transaksi Baru</h1>
            <div class="form-card">
                <form method="POST" action="php/transaksi.php">
                    <div class="form-group">
                        <label for="date" class="form-label">Tanggal</label>
                        <input type="date" id="date" name="date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label">Deskripsi</label>
                        <input type="text" id="description" name="description" class="form-control" placeholder="Contoh: Pembelian ATK" required>
                    </div>
                    <div class="form-group">
                        <label for="type" class="form-label">Jenis</label>
                        <select id="type" name="type" class="form-control" required>
                            <option value="debit">Debit (Pemasukan)</option>
                            <option value="kredit">Kredit (Pengeluaran)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount" class="form-label">Jumlah</label>
                        <input type="number" id="amount" name="amount" class="form-control" placeholder="Contoh: 50000" required>
                    </div>
                    <div class="form-group">
                        <label for="account_id" class="form-label">Akun</label>
                        <select id="account_id" name="account_id" class="form-control" required>
                            <?php foreach ($accounts as $acc): ?>
                                <option value="<?= $acc['id'] ?>"><?= $acc['account_code'] ?> - <?= $acc['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" name="submit" class="btn-theme btn-submit">Simpan Transaksi</button>
                </form>
            </div>
        </main>
    </div>

    <script>
        // (Salin blok <script> dari kode index.php di atas ke sini)
    </script>
</body>
</html>