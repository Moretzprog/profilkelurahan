<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $parent_id = intval($_POST['parent_id']);
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    // Generate slug unik
    $slug_base = strtolower(str_replace(' ', '-', $judul));
    $slug = $slug_base;
    $count = 1;
    while (mysqli_num_rows(mysqli_query($koneksi, "SELECT slug FROM t_galeri WHERE slug = '$slug'")) > 0) {
        $slug = $slug_base . '-' . $count++;
    }

    // Upload gambar - PERBAIKAN PATH
    $target_dir = "../uploads/galeri/";  // ✅ Naik 1 level dari pages/
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $filename = time() . "-" . basename($_FILES["gambar"]["name"]);
    $target_file = $target_dir . $filename;
    
    // Upload file
    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
        // Path untuk database (tanpa ../)
        $gambar_path = "uploads/galeri/" . $filename;
        
        // ✅ PERBAIKAN: Simpan ke t_galeri, bukan t_sub_album
        $query = "INSERT INTO t_galeri (parent_id, judul, deskripsi, gambar, slug, tanggal_upload) 
                  VALUES ('$parent_id', '$judul', '$deskripsi', '$gambar_path', '$slug', NOW())";
        
        if (mysqli_query($koneksi, $query)) {
            // ✅ PERBAIKAN: Ambil slug parent dari database
            $query_parent = "SELECT slug FROM t_galeri WHERE id = $parent_id";
            $result_parent = mysqli_query($koneksi, $query_parent);
            $parent = mysqli_fetch_assoc($result_parent);
            
            // Redirect ke halaman galeri parent
            header("Location: ../galeri.php?slug=" . $parent['slug']);
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