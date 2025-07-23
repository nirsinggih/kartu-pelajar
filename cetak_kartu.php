<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('fpdf/fpdf.php');
require('phpqrcode/qrlib.php');
require('db.php');

class PDF_Kartu extends FPDF {
    function Header() {
        // Kosongkan header jika tidak ingin ada
    }

    function Footer() {
        // Tambahkan footer di bagian bawah halaman
        $this->SetY(-10); // 10 mm dari bawah
        $this->SetFont('Arial','I',10);
        $this->Cell(0, 10, 'Cukup di Print, potong, lipat, laminating. Aplikasi lainya di www.tasadmin.id', 0, 0, 'C');
    }

    function gambarDepan($x, $y, $data, $pengaturan) {
        $this->SetXY($x, $y);
        $this->Rect($x, $y, 86, 54);
        $this->SetFont('Arial','B',10);
        
         // Background dinamis dari database
    $background_path = 'assets/background/' . $pengaturan['background'];
    if (file_exists($background_path)) {
        $this->Image($background_path, $x, $y, 86, 54);
    }


        $logo_path = 'assets/logo/' . $pengaturan['logo'];
        if (file_exists($logo_path)) {
            $this->Image($logo_path, $x + 2, $y + 1, 7);
        }

        $this->SetTextColor(255, 255, 255);
        $this->SetXY($x + 10, $y + 3);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(60, 5, strtoupper($pengaturan['nama_sekolah']), 0, 1, 'L');
        $this->SetTextColor(0, 0, 0);

        $foto = 'foto/'.$data['nisn'].'.jpg';
        if (!file_exists($foto)) {
            $foto = 'foto/default.jpg';
        }
        $this->Image($foto, $x + 4, $y + 20, 20, 25);

        $this->Text($x + 12, $y + 16, 'Nama: '.$data['nama']);
        $this->Text($x + 27, $y + 21, 'NISN: '.$data['nisn']);
        $this->Text($x + 27, $y + 26, 'NIS: '.$data['nis']);
        $this->SetFont('Arial', '', 8);
        $this->Text($x + 27, $y + 31, 'TL: '.$data['tempat_lahir']);
        $this->Text($x + 27, $y + 36, 'Tgl.: '.$data['tanggal_lahir']);
        $this->Text($x + 27, $y + 41, 'Jenis Kelamin: '.$data['jenis_kelamin']);

        if (!is_dir('temp_qr')) mkdir('temp_qr', 0755, true);
        $qr_file = 'temp_qr/'.$data['nisn'].'.png';
        QRcode::png($data['nisn'], $qr_file, 'L', 2, 1);
        $this->Image($qr_file, $x + 55, $y + 25, 20, 20);
    }

    function gambarBelakang($x, $y, $data, $pengaturan) {
		
         // Background dinamis dari database
    $background_path = 'assets/background_belakang/' . $pengaturan['background_belakang'];
    if (file_exists($background_path)) {
        $this->Image($background_path, $x, $y, 86, 54);
    }

		
        $this->SetXY($x, $y);
        $this->Rect($x, $y, 86, 54);
        $this->SetFont('Arial','',7);

        // Geser keterangan ke atas agar tanda tangan tidak terlalu bawah
        $this->SetXY($x + 2, $y + 10);
        $this->MultiCell(75, 5, 
            "Pemegang kartu ini adalah peserta didik.\nJika menemukan, mohon dikembalikan ke:\n" .
            $pengaturan['nama_sekolah'] . "\n" .
            $pengaturan['alamat'], 0, 'L');

        // Tanggal statis
        $this->SetXY($x + 2, $y + 30);
        $this->Cell(75, 5, '29 Juli 2025', 0, 1, 'R');

        $this->SetXY($x + 2, $y + 33);
        $this->Cell(75, 5, "Kepala Sekolah,", 0, 1, 'R');

        $ttd_path = 'assets/tanda_tangan/' . $pengaturan['tanda_tangan'];
        if (file_exists($ttd_path)) {
            $this->Image($ttd_path, $x + 50, $y + 37, 30, 10);
        }

        $this->SetXY($x + 2, $y + 43);
        $this->Cell(75, 5, $pengaturan['kepala_sekolah'], 0, 1, 'R');
		$this->SetXY($x + 2, $y + 46);
		$this->Cell(75, 5, 'NIP ' . $pengaturan['nip_kepala_sekolah'], 0, 1, 'R');
    }
}

// Ambil parameter kelas dari URL
$kelas = isset($_GET['kelas']) ? mysqli_real_escape_string($conn, $_GET['kelas']) : '';

if ($kelas !== '') {
    $q = mysqli_query($conn, "SELECT * FROM siswa WHERE kelas = '$kelas'");
} else {
    $q = mysqli_query($conn, "SELECT * FROM siswa");
}

$siswa = [];
while ($r = mysqli_fetch_assoc($q)) {
    $siswa[] = $r;
}

$siswa = [];

if (isset($_GET['nisn'])) {
    $nisn = mysqli_real_escape_string($conn, $_GET['nisn']);
    $q = mysqli_query($conn, "SELECT * FROM siswa WHERE nisn = '$nisn'");
} elseif (isset($_GET['kelas'])) {
    $kelas = mysqli_real_escape_string($conn, $_GET['kelas']);
    $q = mysqli_query($conn, "SELECT * FROM siswa WHERE kelas = '$kelas'");
} else {
    $q = mysqli_query($conn, "SELECT * FROM siswa");
}

while ($r = mysqli_fetch_assoc($q)) {
    $siswa[] = $r;
}

$pengaturan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pengaturan LIMIT 1"));

$pdf = new PDF_Kartu('P', 'mm', 'A4');
$pdf->SetMargins(0, 0);
$pdf->AddPage();

for ($i = 0; $i < count($siswa); $i++) {
    $x = 10;
    $y = 10 + ($i % 4) * 70;
    $pdf->gambarDepan($x, $y, $siswa[$i], $pengaturan);
    $pdf->gambarBelakang($x + 90, $y, $siswa[$i], $pengaturan);

    if (($i + 1) % 4 == 0 && $i + 1 < count($siswa)) {
        $pdf->AddPage();
    }
}

$pdf->Output();
