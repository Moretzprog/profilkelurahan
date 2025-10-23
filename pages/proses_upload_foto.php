<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $album_id = intval($_POST['sub_album_id']);

    // Upload gambar
    $target_dir = "../uploads/kegiatan/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $filename = time() . "-" . basename($_FILES["gambar"]["name"]);
    $target_file = $target_dir . $filename;

    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
        $gambar_path = "uploads/kegiatan/" . $filename;

        // Sesuai struktur tabel
        $query = "INSERT INTO t_foto (album_id, gambar) VALUES ('$album_id', '$gambar_path')";

        if (mysqli_query($koneksi, $query)) {
            // Redirect ke halaman kegiatan.php sub-album
            $query_sub = "SELECT slug, parent_id FROM t_galeri WHERE id = $album_id ";
            $result_sub = mysqli_query($koneksi, $query_sub);
            $sub = mysqli_fetch_assoc($result_sub);

            header("Location: ../pages/kegiatan.php?slug=" . $sub['slug']);
            exit;
        } else {
            echo "Error database: " . mysqli_error($koneksi);
        }
    } else {
        echo "Gagal upload gambar. Periksa permission folder.";
    }
} else {
    echo "Invalid request method.";
}
?>
