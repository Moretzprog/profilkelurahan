<?php
include '../koneksi.php';

if (isset($_GET['id']) && isset($_GET['slug'])) {
    $foto_id = mysqli_real_escape_string($koneksi, $_GET['id']);
    $slug = mysqli_real_escape_string($koneksi, $_GET['slug']);
    
    // Ambil data foto untuk hapus file fisik
    $query = "SELECT * FROM t_foto WHERE id = '$foto_id'";
    $result = mysqli_query($koneksi, $query);
    $foto = mysqli_fetch_assoc($result);
    
    if ($foto) {
        // Hapus file fisik
        $file_path = '../' . $foto['gambar'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        
        // Hapus dari database
        $query_delete = "DELETE FROM t_foto WHERE id = '$foto_id'";
        if (mysqli_query($koneksi, $query_delete)) {
            header("Location: kegiatan.php?slug=$slug&status=success");
        } else {
            header("Location: galeri.php?slug=$slug&status=error");
        }
    } else {
        header("Location: galeri.php?slug=$slug&status=notfound");
    }
} else {
    header("Location: galeri.php");
}
exit;
?>