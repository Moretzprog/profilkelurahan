<?php
session_start();
include '../koneksi.php';

header('Content-Type: application/json');

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== TRUE) {
    echo json_encode(["status" => "error", "message" => "Akses ditolak."]);
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // ambil path gambar dulu
    $get = mysqli_query($koneksi, "SELECT gambar FROM t_galeri WHERE id = $id");
    $data = mysqli_fetch_assoc($get);

    if ($data) {
        // hapus file gambar
        $filePath = '../' . $data['gambar'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // hapus data dari database
        $delete = mysqli_query($koneksi, "DELETE FROM t_galeri WHERE id = $id");
        if ($delete) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Gagal menghapus album."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Album tidak ditemukan."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "ID album tidak ditemukan."]);
}
?>
