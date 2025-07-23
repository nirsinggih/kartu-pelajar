<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}
require 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload CSV Siswa</title>
</head>
<body>
    <h2>Upload Data Siswa (CSV)</h2>

    <form method="post" enctype="multipart/form-data">
        <input type="file" name="file" accept=".csv" required>
        <button type="submit" name="upload">Upload</button>
    </form>

<?php
if (isset($_POST['upload'])) {
    $target = 'uploads/' . basename($_FILES['file']['name']);
    if (!is_dir('uploads')) mkdir('uploads', 0755, true);

    if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
        echo "<p>✅ File berhasil diunggah.</p>";

        if (($handle = fopen($target, 'r')) !== false) {
            $i = 0;
            $success = 0;
            $fail = 0;

            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if ($i == 0) { $i++; continue; } // skip header

                // Ambil dan sanitasi data
                $nama   = mysqli_real_escape_string($conn, trim($data[0]));
                $nis    = mysqli_real_escape_string($conn, trim($data[1]));
                $nisn   = mysqli_real_escape_string($conn, trim($data[2]));
                $kelas  = mysqli_real_escape_string($conn, trim($data[3]));
                $jk     = mysqli_real_escape_string($conn, trim($data[4]));
                $tempat = mysqli_real_escape_string($conn, trim($data[5]));
                $tgl    = trim($data[6]);

                // Validasi format tanggal
                $date_valid = DateTime::createFromFormat('Y-m-d', $tgl);
                if (!$date_valid || $date_valid->format('Y-m-d') !== $tgl) {
                    echo "<p>❌ Baris $i: Format tanggal salah ($tgl).</p>";
                    $fail++;
                    continue;
                }

                // Cek duplikat NIS / NISN
                $cek_nis = mysqli_query($conn, "SELECT * FROM siswa WHERE nis='$nis'");
                $cek_nisn = mysqli_query($conn, "SELECT * FROM siswa WHERE nisn='$nisn'");
                $cek_user = mysqli_query($conn, "SELECT * FROM users WHERE username='$nisn'");

                if (mysqli_num_rows($cek_nis) > 0) {
                    echo "<p>❌ Baris $i: NIS duplikat ($nis).</p>";
                    $fail++;
                    continue;
                }

                if (mysqli_num_rows($cek_nisn) > 0 || mysqli_num_rows($cek_user) > 0) {
                    echo "<p>❌ Baris $i: NISN sudah digunakan ($nisn).</p>";
                    $fail++;
                    continue;
                }

                // Simpan data
                $password = md5($nisn);
                mysqli_query($conn, "INSERT INTO users (username, password, role) VALUES ('$nisn', '$password', 'siswa')");
                $user_id = mysqli_insert_id($conn);

                $insert = mysqli_query($conn, "INSERT INTO siswa (nama, nis, nisn, kelas, jenis_kelamin, tempat_lahir, tanggal_lahir, user_id) 
                    VALUES ('$nama', '$nis', '$nisn', '$kelas', '$jk', '$tempat', '$tgl', '$user_id')");

                if ($insert) {
                    $success++;
                } else {
                    echo "<p>❌ Baris $i: Gagal insert ke tabel siswa.</p>";
                    $fail++;
                }
                $i++;
            }

            fclose($handle);
            echo "<hr><p>✅ Sukses: $success | ❌ Gagal: $fail</p>";
        } else {
            echo "<p>❌ Gagal membuka file CSV.</p>";
        }
    } else {
        echo "<p>❌ Upload file gagal.</p>";
    }
}
?>
    <p><a href="dashboard.php">← Kembali ke Dashboard</a></p>
</body>
</html>
