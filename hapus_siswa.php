<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

require 'db.php';

if (isset($_GET['nisn'])) {
    $nisn = mysqli_real_escape_string($conn, $_GET['nisn']);
    $delete = mysqli_query($conn, "DELETE FROM siswa WHERE nisn='$nisn'");

    if ($delete) {
        header("Location: daftar_siswa.php");
    } else {
        echo "Gagal menghapus data.";
    }
} else {
    header("Location: daftar_siswa.php");
}
?>
