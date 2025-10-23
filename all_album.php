<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'koneksi.php';
session_start();

// Ambil semua album induk (parent_id NULL atau 0)
$query_album = "SELECT * FROM t_galeri WHERE parent_id IS NULL OR parent_id = 0 ORDER BY tanggal_upload DESC";
$result_album = mysqli_query($koneksi, $query_album);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Album</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a href="index.php#galeri" class="btn btn-outline-primary rounded-pill">
            <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>

            <span class="navbar-text fw-bold text-primary text-uppercase">ALBUM KELURAHAN SARIJAYA</span>
        </div>
    </nav>
<div class="container py-5">
    <h2 class="fw-bold mb-4">Semua Album</h2>
    <div class="row">
        <?php if ($result_album && mysqli_num_rows($result_album) > 0): ?>
            <?php while ($album = mysqli_fetch_assoc($result_album)): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="<?= htmlspecialchars($album['gambar']) ?>" 
                             class="card-img-top" 
                             style="object-fit:cover; height:220px;" 
                             alt="<?= htmlspecialchars($album['judul']) ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= htmlspecialchars($album['judul']) ?></h5>
                            <p class="card-text small text-muted"><?= htmlspecialchars($album['deskripsi']) ?></p>
                            <a href="pages/sub_album.php?slug=<?= urlencode($album['slug']) ?>" 
                               class="btn btn-outline-primary btn-sm rounded-pill">
                               Lihat Sub Album
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center text-muted">Belum ada album induk.</p>
        <?php endif; ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
