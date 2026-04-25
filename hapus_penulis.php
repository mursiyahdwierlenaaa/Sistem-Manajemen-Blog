<?php
require 'koneksi.php';
header('Content-Type: application/json');

$id = intval($_POST['id'] ?? 0);
if (!$id) {
    echo json_encode(['status' => 'error', 'pesan' => 'ID tidak valid.']);
    exit;
}

// Cek apakah penulis masih punya artikel
$cek = $koneksi->prepare("SELECT COUNT(*) AS jumlah FROM artikel WHERE id_penulis = ?");
$cek->bind_param('i', $id);
$cek->execute();
$jumlah = $cek->get_result()->fetch_assoc()['jumlah'];
$cek->close();

if ($jumlah > 0) {
    echo json_encode(['status' => 'error', 'pesan' => 'Penulis tidak dapat dihapus karena masih memiliki artikel.']);
    exit;
}

// Ambil nama foto lama
$stmt = $koneksi->prepare("SELECT foto FROM penulis WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$data) {
    echo json_encode(['status' => 'error', 'pesan' => 'Data tidak ditemukan.']);
    exit;
}

$del = $koneksi->prepare("DELETE FROM penulis WHERE id = ?");
$del->bind_param('i', $id);

if ($del->execute()) {
    // Hapus foto jika bukan default
    if ($data['foto'] !== 'default.png') {
        $path = __DIR__ . '/uploads_penulis/' . $data['foto'];
        if (file_exists($path)) unlink($path);
    }
    echo json_encode(['status' => 'sukses', 'pesan' => 'Penulis berhasil dihapus.']);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal menghapus data.']);
}
$del->close();