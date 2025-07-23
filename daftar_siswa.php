<?php
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
    <title>Daftar Siswa</title>
    <style>
    body { font-family: Arial, sans-serif; padding: 20px; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background: #eee; }

    a.button {
        background: #007bff;
        color: #fff;
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 3px;
    }
    a.button:hover {
        background: #0056b3;
    }

    a.button-edit {
        background: #28a745;
        color: #fff;
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 3px;
    }
    a.button-edit:hover {
        background: #1e7e34;
    }

    a.button.button-delete {
    background: #dc3545;
    color: #fff;
    }
    a.button.button-delete:hover {
    background: #b02a37;
    }

</style>

</head>
<body>

    <h2>Daftar Siswa</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>NISN</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Jenis Kelamin</th>
                <th>Tgl Lahir</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $q = mysqli_query($conn, "SELECT * FROM siswa ORDER BY kelas, nama");
        $no = 1;
        while ($row = mysqli_fetch_assoc($q)) {
            echo "<tr>
                <td>$no</td>
                <td>{$row['nis']}</td>
                <td>{$row['nisn']}</td>
                <td>{$row['nama']}</td>
                <td>{$row['kelas']}</td>
                <td>{$row['jenis_kelamin']}</td>
                <td>{$row['tanggal_lahir']}</td>
               <td>
                    <a class='button-edit' href='edit_siswa.php?nisn={$row['nisn']}'>Edit</a>
                     <a class='button' href='cetak_kartu.php?nisn={$row['nisn']}' target='_blank'>Cetak Kartu</a>
                     <a class='button button-delete' href='hapus_siswa.php?nisn={$row['nisn']}' onclick=\"return confirm('Yakin ingin menghapus siswa ini?');\">Hapus</a>
                </td>

            </tr>";
            $no++;
        }
        ?>
        </tbody>
    </table>

    <p><a href="dashboard.php">← Kembali ke Dashboard</a></p>
</body>
</html>
