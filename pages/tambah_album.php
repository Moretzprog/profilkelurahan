<?php
session_start();
include '../koneksi.php';

header('Content-Type: application/json');

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== TRUE) {
    echo json_encode(["status" => "error", "message" => "Akses ditolak."]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $slug = strtolower(str_replace(' ', '-', $judul)); // otomatis buat slug

    // folder upload
    $targetDir = "../uploads/galeri";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // cek file upload
    if (!empty($_FILES['gambar']['name'])) {
        $fileName = time() . '_' . basename($_FILES['gambar']['name']);
        $targetFile = $targetDir . '/' . $fileName;

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
            $path = "uploads/galeri/" . $fileName;

            // simpan ke database
            $query = "INSERT INTO t_galeri (judul, deskripsi, gambar, kategori, slug)
                      VALUES ('$judul', '$deskripsi', '$path', '$kategori', '$slug')";
            if (mysqli_query($koneksi, $query)) {
                echo json_encode(["status" => "success", "message" => "Album berhasil ditambahkan."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Gagal menyimpan ke database."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Gagal mengupload gambar."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Gambar wajib diunggah."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Metode tidak valid."]);
}
?>
