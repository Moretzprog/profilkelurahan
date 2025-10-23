<?php
include '../koneksi.php';

header('Content-Type: application/json; charset=utf-8'); // ✅ tambahkan ini

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deskripsi = $_POST['deskripsi'] ?? '';
    $visi = $_POST['visi'] ?? '';
    $misi = $_POST['misi'] ?? '';

    $query = "UPDATE profil_kelurahan SET deskripsi = ?, visi = ?, misi = ? WHERE id = 1";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("sss", $deskripsi, $visi, $misi);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }

    $stmt->close();
    $koneksi->close();
    exit;
}

echo json_encode(["status" => "error", "message" => "Invalid request method"]);
exit;

