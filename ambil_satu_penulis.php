<?php
require 'koneksi.php';
header('Content-Type: application/json');

$id = intval($_GET['id'] ?? 0);
if (!$id) {
    echo json_encode(['status' => 'error', 'pesan' => 'ID tidak valid.']);
    exit;
}

$stmt = $koneksi->prepare("SELECT id, nama_depan, nama_belakang, user_name, password, foto FROM penulis WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if ($data) {
    echo json_encode(['status' => 'sukses', 'data' => $data]);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Data tidak ditemukan.']);
}
$stmt->close();