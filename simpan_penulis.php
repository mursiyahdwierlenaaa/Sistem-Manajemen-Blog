<?php
require 'koneksi.php';
header('Content-Type: application/json');

$nama_depan   = trim($_POST['nama_depan'] ?? '');
$nama_belakang = trim($_POST['nama_belakang'] ?? '');
$user_name    = trim($_POST['user_name'] ?? '');
$password     = $_POST['password'] ?? '';

if (!$nama_depan || !$nama_belakang || !$user_name || !$password) {
    echo json_encode(['status' => 'error', 'pesan' => 'Semua field wajib diisi.']);
    exit;
}

$foto = 'default.png';

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
        echo json_encode(['status' => 'error', 'pesan' => 'Tipe file tidak diizinkan. Gunakan JPG, PNG, GIF, atau WEBP.']);
        exit;
    }

    $ext  = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $namaFile = uniqid('penulis_') . '.' . strtolower($ext);
    $tujuan   = __DIR__ . '/uploads_penulis/' . $namaFile;

    if (!move_uploaded_file($_FILES['foto']['tmp_name'], $tujuan)) {
        echo json_encode(['status' => 'error', 'pesan' => 'Gagal mengupload foto.']);
        exit;
    }
    $foto = $namaFile;
}

$hash = password_hash($password, PASSWORD_BCRYPT);

$stmt = $koneksi->prepare("INSERT INTO penulis (nama_depan, nama_belakang, user_name, password, foto) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param('sssss', $nama_depan, $nama_belakang, $user_name, $hash, $foto);

if ($stmt->execute()) {
    echo json_encode(['status' => 'sukses', 'pesan' => 'Penulis berhasil ditambahkan.']);
} else {
    // cek duplicate username
    if ($koneksi->errno === 1062) {
        echo json_encode(['status' => 'error', 'pesan' => 'Username sudah digunakan.']);
    } else {
        echo json_encode(['status' => 'error', 'pesan' => 'Gagal menyimpan data: ' . $stmt->error]);
    }
}
$stmt->close();