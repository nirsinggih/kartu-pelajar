<?php
// File: dashboard.php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            margin: 0;
            background-color: #f4f4f4;
        }
        h2 {
            text-align: center;
            color: #003366;
        }
        ul {
            list-style-type: none;
            padding: 0;
            margin: 20px auto;
            max-width: 400px;
        }
        li {
            margin-bottom: 15px;
        }

        a {
            display: block;
            color: white;
            padding: 12px;
            border-radius: 8px;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.2s ease;
        }

        .excel {
            background-color: #217346;
        }
        .excel:hover {
            background-color: #1e5e3e;
        }

        .powerpoint {
            background-color: #d24726;
        }
        .powerpoint:hover {
            background-color: #a7351c;
        }

        .word {
            background-color: #2b579a;
        }
        .word:hover {
            background-color: #1e3e73;
        }

        .canva {
            background-color: #00c4cc;
        }
        .canva:hover {
            background-color: #009aa1;
        }

        .whatsapp {
            background-color: #25D366;
        }
        .whatsapp:hover {
            background-color: #1da851;
        }

        .danger {
            background-color: #c62828;
        }
        .danger:hover {
            background-color: #a32020;
        }

        .default {
            background-color: #003366;
        }
        .default:hover {
            background-color: #001f4d;
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }
            a {
                font-size: 16px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <h2>Selamat datang, Admin!</h2>
    <ul>
        <li><a href="upload_excel.php" class="excel">Upload Data Siswa EXCEL (xls)</a></li>
        <li><a href="upload_foto.php" class="powerpoint">Upload Foto Siswa (Pilih)</a></li>
        <li><a href="edit_profil.php" class="word">Pengaturan Profil Sekolah</a></li>
        <li><a href="pilih_kelas.php" class="canva">Cetak Kartu Per Kelas</a></li>
        <li><a href="cetak_kartu.php" class="default">Cetak Semua Kartu</a></li>
        <li><a href="daftar_siswa.php" class="default">Daftar Nama Siswa</a></li>
        <li><a href="https://chat.whatsapp.com/KtdYP6nx3eZLVhqJkQ1Zbs?mode=r_c" class="whatsapp">Gabung Grup WA</a></li>
        <li><a href="reset_database.php" class="danger">RESET DATABASE</a></li>
        <li><a href="logout.php" class="default">Logout</a></li>
    </ul>
</body>
</html>
