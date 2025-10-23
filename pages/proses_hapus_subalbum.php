<?php
session_start();
include '../koneksi.php';

// Cek apakah ada ID yang dikirim
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "ID Sub Album tidak valid!";
    header('Location: ../index.php');
    exit;
}

$sub_album_id = intval($_GET['id']);

// Ambil data sub album untuk mendapatkan parent_id dan slug parent
$query_sub = "SELECT g.*, parent.slug as parent_slug 
              FROM t_galeri g 
              LEFT JOIN t_galeri parent ON g.parent_id = parent.id 
              WHERE g.id = ? LIMIT 1";
$stmt_sub = mysqli_prepare($koneksi, $query_sub);
mysqli_stmt_bind_param($stmt_sub, "i", $sub_album_id);
mysqli_stmt_execute($stmt_sub);
$result_sub = mysqli_stmt_get_result($stmt_sub);
$sub_album = mysqli_fetch_assoc($result_sub);

if (!$sub_album) {
    $_SESSION['error'] = "Sub Album tidak ditemukan!";
    header('Location: ../index.php');
    exit;
}

$parent_slug = $sub_album['parent_slug'];
$gambar_sub_album = $sub_album['gambar'];

// Mulai transaksi
mysqli_begin_transaction($koneksi);

try {
    // 1. Ambil semua foto dari sub album untuk dihapus file-nya
    $query_foto = "SELECT gambar FROM t_foto WHERE album_id = ?";
    $stmt_foto = mysqli_prepare($koneksi, $query_foto);
    mysqli_stmt_bind_param($stmt_foto, "i", $sub_album_id);
    mysqli_stmt_execute($stmt_foto);
    $result_foto = mysqli_stmt_get_result($stmt_foto);
    
    // Hapus semua file foto
    while ($foto = mysqli_fetch_assoc($result_foto)) {
        $file_path = '../' . $foto['gambar'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
    mysqli_stmt_close($stmt_foto);
    
    // 2. Hapus semua foto dari database
    $query_delete_foto = "DELETE FROM t_foto WHERE album_id = ?";
    $stmt_delete_foto = mysqli_prepare($koneksi, $query_delete_foto);
    mysqli_stmt_bind_param($stmt_delete_foto, "i", $sub_album_id);
    mysqli_stmt_execute($stmt_delete_foto);
    mysqli_stmt_close($stmt_delete_foto);
    
    // 3. Hapus file gambar sampul sub album
    if (!empty($gambar_sub_album) && file_exists('../' . $gambar_sub_album)) {
        unlink('../' . $gambar_sub_album);
    }
    
    // 4. Hapus sub album dari database
    $query_delete_sub = "DELETE FROM t_galeri WHERE id = ?";
    $stmt_delete_sub = mysqli_prepare($koneksi, $query_delete_sub);
    mysqli_stmt_bind_param($stmt_delete_sub, "i", $sub_album_id);
    mysqli_stmt_execute($stmt_delete_sub);
    mysqli_stmt_close($stmt_delete_sub);
    
    // Commit transaksi
    mysqli_commit($koneksi);
    
    $_SESSION['success'] = "Sub Album berhasil dihapus beserta semua foto di dalamnya!";
    
} catch (Exception $e) {
    // Rollback jika terjadi error
    mysqli_rollback($koneksi);
    $_SESSION['error'] = "Gagal menghapus Sub Album: " . $e->getMessage();
}

mysqli_stmt_close($stmt_sub);
mysqli_close($koneksi);

// Redirect kembali ke halaman galeri parent
header('Location: ../galeri.php?slug=' . $parent_slug);
exit;
?>