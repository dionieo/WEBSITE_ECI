<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/index.css">
    <style>
        body {
            background: #fff;
            font-family: 'calibri', monospace;
            margin: 0;
            padding: 0;
        }
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
        .container-main {
            max-width: 1000px;
            margin: 40px auto;
            /* background: #fff; */
            border-radius: 8px;
            /* box-shadow: 0 2px 12px rgba(0,0,0,0.07); */
            padding: 2rem 1.5rem;
        }
        .welcome {
            font-size: 1.5rem;
            margin: 2rem;
            text-align: center;
        }
        .menu {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-top: 1rem;
        }

        .menus {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-top: 1rem;
        }
        .tile {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            aspect-ratio: 1/ 1;
            border-radius: 12px;
            text-align: center;
            text-decoration: none;
            font-weight: bold;
            color: #fff;
            font-size: 1rem;
            transition: transform 0.2s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .tiled {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            aspect-ratio: 2/ 1;
            border-radius: 12px;
            text-align: center;
            text-decoration: none;
            font-weight: bold;
            color: #fff;
            font-size: 1rem;
            transition: transform 0.2s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .tile:hover {
            transform: scale(1.05);
            filter: brightness(1.1);
        }
        .tiled:hover {
            transform: scale(1.05);
            filter: brightness(1.1);
        }
        .tile .icon {
            font-size: 2.5rem;
            margin-bottom: 0.4em;
        }
        .tiled .icon {
            font-size: 2.5rem;
            margin-bottom: 0.4em;
        }
        .tile1 { background: #0096c7; }
        .tile2 { background: #f77f00; }
        .tile3 { background: #d62828; }
        .tile4 { background: #6a4c93; }
        .tile5 { background: #2a9d8f; }
    
        @media (max-width: 768px) {
            .menu, .menus {
                grid-template-columns: 1fr;
            }
            .tile, .tiled {
                aspect-ratio: 2/1;
                width: 100%;
                font-size: 0.95rem;
                height: auto;
                min-width: 0;
            }

            .navbar-brand img{
                height: 80px;
                width: auto;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="./img/icon.png" alt=""></a>
            <a href="logout.php" class="logout-btn" onclick="return confirm('Apakah Anda yakin ingin logout?');">Logout</a>
        </div>
    </div>
    <div class="container-main">
        <div class="welcome">
            Selamat datang, <strong><?= htmlspecialchars($_SESSION['username']); ?></strong>!
        </div>
        <div class="menu">
            <a href="input-transaksi.php" class="tile tile1">
                Input Transaksi
            </a>
            <a href="laporan.php" class="tile tile2">
                Laporan Keuangan
            </a>
            <a href="jurnal.php" class="tile tile3">
                Jurnal Umum
            </a>
        </div>
        <div class="menus">
            <a href="neraca-detail.php" class="tiled tile4">
                Neraca
            </a>
            <a href="buku-besar.php" class="tiled tile5">
                Buku Besar
            </a>
        </div>
    </div>
</body>
</html>
