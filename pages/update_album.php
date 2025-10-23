<?php
include '../koneksi.php';

$id = $_POST['id'];
$judul = $_POST['judul'];
$deskripsi = $_POST['deskripsi'];

// Ambil data lama
$q = mysqli_query($koneksi, "SELECT gambar FROM t_galeri WHERE id='$id'");
$old = mysqli_fetch_assoc($q);
$old_gambar = $old['gambar'] ?? null;

$targetDir = "../uploads/galeri/";
$newFileName = $old_gambar; // default pakai yang lama

if (!empty($_FILES['gambar']['name'])) {
    $fileName = time() . "_" . basename($_FILES["gambar"]["name"]);
    $targetFile = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Validasi tipe file
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($fileType, $allowed)) {
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFile)) {
            // Hapus gambar lama
            if ($old_gambar && file_exists($targetDir . $old_gambar)) {
                unlink($targetDir . $old_gambar);
            }
            $newFileName = $fileName;
        }
    }
}

// Update database
$query = "UPDATE t_galeri SET judul='$judul', deskripsi='$deskripsi', gambar='$newFileName' WHERE id='$id'";
if (mysqli_query($koneksi, $query)) {
    echo json_encode(["status" => "success", "message" => "Album berhasil diperbarui"]);
} else {
    echo json_encode(["status" => "error", "message" => "Gagal memperbarui album"]);
}

mysqli_close($koneksi);