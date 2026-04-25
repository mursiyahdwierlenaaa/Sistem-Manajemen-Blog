<?php
require 'koneksi.php';
header('Content-Type: application/json');

$judul       = trim($_POST['judul'] ?? '');
$id_penulis  = intval($_POST['id_penulis'] ?? 0);
$id_kategori = intval($_POST['id_kategori'] ?? 0);
$isi         = trim($_POST['isi'] ?? '');

if (!$judul || !$id_penulis || !$id_kategori || !$isi) {
    echo json_encode(['status' => 'error', 'pesan' => 'Semua field wajib diisi.']);
    exit;
}

// Validasi gambar wajib ada
if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['status' => 'error', 'pesan' => 'Gambar artikel wajib diunggah.']);
    exit;
}

$maxSize = 2 * 1024 * 1024;
if ($_FILES['gambar']['size'] > $maxSize) {
    echo json_encode(['status' => 'error', 'pesan' => 'Ukuran gambar maksimal 2 MB.']);
    exit;
}

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime  = $finfo->file($_FILES['gambar']['tmp_name']);
$allowedMime = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
if (!in_array($mime, $allowedMime)) {
    echo json_encode(['status' => 'error', 'pesan' => 'Tipe file tidak diizinkan.']);
    exit;
}

$ext      = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
$namaFile = uniqid('artikel_') . '.' . strtolower($ext);
$tujuan   = __DIR__ . '/uploads_artikel/' . $namaFile;

if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $tujuan)) {
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal mengupload gambar.']);
    exit;
}

// Generate hari_tanggal dari server
date_default_timezone_set('Asia/Jakarta');
$hari   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
$bulan  = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
           7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
$sekarang   = new DateTime();
$nama_hari  = $hari[$sekarang->format('w')];
$tanggal    = $sekarang->format('j');
$nama_bulan = $bulan[(int)$sekarang->format('n')];
$tahun      = $sekarang->format('Y');
$jam        = $sekarang->format('H:i');
$hari_tanggal = "$nama_hari, $tanggal $nama_bulan $tahun | $jam";

$stmt = $koneksi->prepare("INSERT INTO artikel (id_penulis, id_kategori, judul, isi, gambar, hari_tanggal) VALUES (?,?,?,?,?,?)");
$stmt->bind_param('iissss', $id_penulis, $id_kategori, $judul, $isi, $namaFile, $hari_tanggal);

if ($stmt->execute()) {
    echo json_encode(['status' => 'sukses', 'pesan' => 'Artikel berhasil ditambahkan.']);
} else {
    // Hapus gambar yang sudah terupload jika query gagal
    if (file_exists($tujuan)) unlink($tujuan);
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal menyimpan artikel: ' . $stmt->error]);
}
$stmt->close();