<?php
require 'koneksi.php';
header('Content-Type: application/json');

$id          = intval($_POST['id'] ?? 0);
$judul       = trim($_POST['judul'] ?? '');
$id_penulis  = intval($_POST['id_penulis'] ?? 0);
$id_kategori = intval($_POST['id_kategori'] ?? 0);
$isi         = trim($_POST['isi'] ?? '');

if (!$id || !$judul || !$id_penulis || !$id_kategori || !$isi) {
    echo json_encode(['status' => 'error', 'pesan' => 'Data tidak lengkap.']);
    exit;
}

// Ambil gambar lama
$stmt = $koneksi->prepare("SELECT gambar FROM artikel WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$lama = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$lama) {
    echo json_encode(['status' => 'error', 'pesan' => 'Data tidak ditemukan.']);
    exit;
}

$gambar = $lama['gambar'];

// Proses upload gambar baru jika ada
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
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

    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $tujuan)) {
        // Hapus gambar lama
        $pathLama = __DIR__ . '/uploads_artikel/' . $lama['gambar'];
        if (file_exists($pathLama)) unlink($pathLama);
        $gambar = $namaFile;
    } else {
        echo json_encode(['status' => 'error', 'pesan' => 'Gagal mengupload gambar.']);
        exit;
    }
}

$stmt = $koneksi->prepare("UPDATE artikel SET id_penulis=?, id_kategori=?, judul=?, isi=?, gambar=? WHERE id=?");
$stmt->bind_param('iisssi', $id_penulis, $id_kategori, $judul, $isi, $gambar, $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'sukses', 'pesan' => 'Artikel berhasil diperbarui.']);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal memperbarui artikel.']);
}
$stmt->close();