<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

require 'db.php';
require_once 'phpexcel/Classes/PHPExcel.php';

$success = 0;
$fail = 0;

if (isset($_POST['upload'])) {
    $file = $_FILES['file']['tmp_name'];

    $excelReader = PHPExcel_IOFactory::createReaderForFile($file);
    $excelObj = $excelReader->load($file);
    $sheet = $excelObj->getActiveSheet();
    $rows = $sheet->toArray(null, true, true, true);

    foreach ($rows as $i => $row) {
        if ($i == 1) continue; // skip header

        $nama = mysqli_real_escape_string($conn, $row['A']);
        $nis = mysqli_real_escape_string($conn, $row['B']);
        $nisn = mysqli_real_escape_string($conn, $row['C']);
        $kelas = mysqli_real_escape_string($conn, $row['D']);
        $jk = mysqli_real_escape_string($conn, $row['E']);
        $tempat = mysqli_real_escape_string($conn, $row['F']);
        $tgl = mysqli_real_escape_string($conn, $row['G']);

        // Cek duplikat NISN
        $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$nisn'");
        if (mysqli_num_rows($cek) > 0) {
            $fail++;
            continue;
        }

        $password = md5($nisn);
        mysqli_query($conn, "INSERT INTO users (username, password, role) VALUES ('$nisn', '$password', 'siswa')");
        $user_id = mysqli_insert_id($conn);

        $insert = mysqli_query($conn, "INSERT INTO siswa (nama, nis, nisn, kelas, jenis_kelamin, tempat_lahir, tanggal_lahir, user_id) 
        VALUES ('$nama', '$nis', '$nisn', '$kelas', '$jk', '$tempat', '$tgl', '$user_id')");

        $insert ? $success++ : $fail++;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Upload Data Siswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #182c47;
            color: #fff;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #f5f5f5;
            text-align: center;
        }

        form {
            background-color: #243b5e;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        }

        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background: #f0f0f0;
            border-radius: 5px;
            border: none;
            color: #000; /* tambahkan ini agar teks terlihat */
        }

        button {
            width: 100%;
            background-color: #4267B2;
            color: white;
            padding: 12px;
            border: none;
            margin-top: 10px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #365899;
        }

        .info, .link {
            max-width: 400px;
            margin: 10px auto;
            text-align: center;
        }

        .info p {
            font-size: 16px;
        }

        .link a {
            font-weight: bold;
            color: #fff;
            text-decoration: none;
        }

        .link a:hover {
            text-decoration: underline;
        }

        .warning {
            max-width: 400px;
            margin: 0 auto;
            text-align: center;
            font-size: 14px;
            background-color: #ffcc00;
            color: #000;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
        }

        @media (max-width: 500px) {
            form, .info, .link, .warning {
                width: 90%;
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<h2>Upload Excel (.xls / .xlsx)</h2>

<?php if (isset($_POST['upload'])): ?>
    <div class="info">
        <p>✅ Berhasil: <?= $success ?> | ❌ Gagal: <?= $fail ?></p>
    </div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="file" required>
    <button name="upload">Upload</button>
</form>

<div class="warning">
    ⚠️ Format kolom pada Excel harus sama, <strong>jangan diubah urutannya</strong>!
</div>

<div class="link">
    <p>📥 <a href="format_data_siswa.xls" download>Unduh Format Data Excel</a></p>
    <p><a href="daftar_siswa.php">Lihat daftar siswa</a></p>
    <p><a href="dashboard.php">← Kembali ke Dashboard</a></p>
</div>

</body>
</html>
