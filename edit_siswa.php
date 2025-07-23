<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

require 'db.php';

// Cek jika tidak ada nisn di parameter
if (!isset($_GET['nisn'])) {
    echo "NISN tidak ditemukan.";
    exit;
}

$nisn = mysqli_real_escape_string($conn, $_GET['nisn']);
$query = mysqli_query($conn, "SELECT * FROM siswa WHERE nisn = '$nisn'");
$siswa = mysqli_fetch_assoc($query);

if (!$siswa) {
    echo "Data siswa tidak ditemukan.";
    exit;
}

if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $nis = mysqli_real_escape_string($conn, $_POST['nis']);
    $kelas = mysqli_real_escape_string($conn, $_POST['kelas']);
    $jk = mysqli_real_escape_string($conn, $_POST['jk']);
    $tempat = mysqli_real_escape_string($conn, $_POST['tempat']);
    $tgl = mysqli_real_escape_string($conn, $_POST['tgl']);

    mysqli_query($conn, "UPDATE siswa SET 
        nama = '$nama',
        nis = '$nis',
        kelas = '$kelas',
        jenis_kelamin = '$jk',
        tempat_lahir = '$tempat',
        tanggal_lahir = '$tgl'
        WHERE nisn = '$nisn'");

    echo "<p style='color:green'>✔ Data berhasil diperbarui.</p>";
    // Refresh data
    $siswa = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM siswa WHERE nisn = '$nisn'"));
}

if (isset($_POST['upload_foto']) && isset($_FILES['foto']['tmp_name'])) {
    $target = 'foto/' . $nisn . '.jpg';
    move_uploaded_file($_FILES['foto']['tmp_name'], $target);
    echo "<p style='color:green'>✔ Foto berhasil diunggah.</p>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Siswa - <?= htmlspecialchars($siswa['nama']) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
            max-width: 600px;
            margin: auto;
        }
        h2, h3 {
            color: #333;
        }
        label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="date"],
        select,
        input[type="file"] {
            padding: 8px;
            width: 100%;
            box-sizing: border-box;
            margin-top: 4px;
        }
        .btn {
            margin-top: 15px;
            padding: 10px 15px;
            background-color: #007BFF;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 4px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        img {
            margin-top: 12px;
            border: 1px solid #ccc;
            max-width: 100%;
            height: auto;
        }
        .back {
            display: inline-block;
            margin-top: 20px;
            color: #007BFF;
            text-decoration: none;
        }
        .back:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }
            h2, h3 {
                font-size: 18px;
            }
            .btn {
                width: 100%;
                padding: 12px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

<h2>Edit Data Siswa</h2>

<form method="post">
    <label>Nama Lengkap</label>
    <input type="text" name="nama" value="<?= htmlspecialchars($siswa['nama']) ?>" required>

    <label>NIS</label>
    <input type="text" name="nis" value="<?= htmlspecialchars($siswa['nis']) ?>" required>

    <label>Kelas</label>
    <input type="text" name="kelas" value="<?= htmlspecialchars($siswa['kelas']) ?>" required>

    <label>Jenis Kelamin</label>
    <select name="jk">
        <option value="L" <?= $siswa['jenis_kelamin'] == 'L' ? 'selected' : '' ?>>Laki-laki</option>
        <option value="P" <?= $siswa['jenis_kelamin'] == 'P' ? 'selected' : '' ?>>Perempuan</option>
    </select>

    <label>Tempat Lahir</label>
    <input type="text" name="tempat" value="<?= htmlspecialchars($siswa['tempat_lahir']) ?>">

    <label>Tanggal Lahir</label>
    <input type="date" name="tgl" value="<?= $siswa['tanggal_lahir'] ?>">

    <button type="submit" name="update" class="btn">Simpan Perubahan</button>
</form>

<h3>Foto Siswa</h3>
<?php
$foto_path = 'foto/' . $siswa['nisn'] . '.jpg';
if (file_exists($foto_path)) {
    echo "<img src='$foto_path?".time()."'>";
} else {
    echo "<p>Belum ada foto</p>";
}
?>
<form method="post" enctype="multipart/form-data">
    <label>Ganti Foto (JPG)</label>
    <input type="file" name="foto" accept=".jpg" required>
    <button type="submit" name="upload_foto" class="btn">Upload Foto</button>
</form>

<p><a href="daftar_siswa.php" class="back">← Kembali ke Daftar Siswa</a></p>

</body>
</html>
