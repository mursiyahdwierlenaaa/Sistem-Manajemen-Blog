<?php
require 'koneksi.php';
header('Content-Type: application/json');

$id            = intval($_POST['id'] ?? 0);
$nama_depan    = trim($_POST['nama_depan'] ?? '');
$nama_belakang = trim($_POST['nama_belakang'] ?? '');
$user_name     = trim($_POST['user_name'] ?? '');
$password      = $_POST['password'] ?? '';

if (!$id || !$nama_depan || !$nama_belakang || !$user_name) {
    echo json_encode(['status' => 'error', 'pesan' => 'Data tidak lengkap.']);
    exit;
}

// Ambil data lama
$stmt = $koneksi->prepare("SELECT foto FROM penulis WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$lama = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$lama) {
    echo json_encode(['status' => 'error', 'pesan' => 'Data tidak ditemukan.']);
    exit;
}

$foto = $lama['foto'];

// Proses upload foto baru jika ada
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $maxSize = 2 * 1024 * 1024;
    if ($_FILES['foto']['size'] > $maxSize) {
        echo json_encode(['status' => 'error', 'pesan' => 'Ukuran file maksimal 2 MB.']);
        exit;
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($_FILES['foto']['tmp_name']);
    $allowedMime = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($mime, $allowedMime)) {
        echo json_encode(['status' => 'error', 'pesan' => 'Tipe file tidak diizinkan.']);
        exit;
    }

    $ext      = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $namaFile = uniqid('penulis_') . '.' . strtolower($ext);
    $tujuan   = __DIR__ . '/uploads_penulis/' . $namaFile;

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $tujuan)) {
        // Hapus foto lama jika bukan default
        if ($lama['foto'] !== 'default.png') {
            $fotoLama = __DIR__ . '/uploads_penulis/' . $lama['foto'];
            if (file_exists($fotoLama)) unlink($fotoLama);
        }
        $foto = $namaFile;
    } else {
        echo json_encode(['status' => 'error', 'pesan' => 'Gagal mengupload foto.']);
        exit;
    }
}

// Update dengan atau tanpa password baru
if (!empty($password)) {
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $koneksi->prepare("UPDATE penulis SET nama_depan=?, nama_belakang=?, user_name=?, password=?, foto=? WHERE id=?");
    $stmt->bind_param('sssssi', $nama_depan, $nama_belakang, $user_name, $hash, $foto, $id);
} else {
    $stmt = $koneksi->prepare("UPDATE penulis SET nama_depan=?, nama_belakang=?, user_name=?, foto=? WHERE id=?");
    $stmt->bind_param('ssssi', $nama_depan, $nama_belakang, $user_name, $foto, $id);
}

if ($stmt->execute()) {
    echo json_encode(['status' => 'sukses', 'pesan' => 'Data penulis berhasil diperbarui.']);
} else {
    if ($koneksi->errno === 1062) {
        echo json_encode(['status' => 'error', 'pesan' => 'Username sudah digunakan.']);
    } else {
        echo json_encode(['status' => 'error', 'pesan' => 'Gagal memperbarui data: ' . $stmt->error]);
    }
}
$stmt->close();