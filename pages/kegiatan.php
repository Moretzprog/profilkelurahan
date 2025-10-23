<?php

include '../koneksi.php';

// Cek slug sub-album
if (!isset($_GET['slug'])) {
    echo "<p>Sub-album tidak ditemukan.</p>";
    exit;
}

$slug = mysqli_real_escape_string($koneksi, $_GET['slug']);

// Ambil data sub-album
$query_sub = "SELECT * FROM t_galeri WHERE slug = '$slug' LIMIT 1";
$result_sub = mysqli_query($koneksi, $query_sub);
$subalbum = mysqli_fetch_assoc($result_sub);

if (!$subalbum) {
    echo "<p>Sub-album tidak ditemukan.</p>";
    exit;
}

// Ambil semua foto dari sub-album
$parent_id = $subalbum['parent_id'];
$query_parent = "SELECT * FROM t_galeri WHERE id = '$parent_id' LIMIT 1";
$result_parent = mysqli_query($koneksi, $query_parent);
$parent_album = mysqli_fetch_assoc($result_parent);

$sub_id = $subalbum['id'];
$query_foto = "SELECT * FROM t_foto WHERE album_id = $sub_id ORDER BY tanggal_upload DESC";
$result_foto = mysqli_query($koneksi, $query_foto);

// Simpan semua foto dalam array untuk navigasi
$all_photos = [];
while ($foto = mysqli_fetch_assoc($result_foto)) {
    $all_photos[] = $foto;
}
mysqli_data_seek($result_foto, 0); // Reset pointer
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($subalbum['judul']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <style>
        /* Modal Gallery Custom */
        .gallery-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.95);
            z-index: 9999;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .gallery-modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .gallery-modal-content {
            position: relative;
            max-width: 90%;
            max-height: 90vh;
            animation: zoomIn 0.3s ease;
        }

        @keyframes zoomIn {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .gallery-modal img {
            max-width: 100%;
            max-height: 85vh;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 10px 50px rgba(0, 0, 0, 0.5);
        }

        .gallery-close-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            color: white;
            font-size: 24px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
        }

        .gallery-close-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg) scale(1.1);
        }

        .gallery-back-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            background: rgba(13, 110, 253, 0.9);
            backdrop-filter: blur(10px);
            color: white;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            z-index: 10000;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.4);
        }

        .gallery-back-btn:hover {
            background: rgba(13, 110, 253, 1);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(13, 110, 253, 0.6);
        }

        .gallery-nav-btn {
            position: fixed;
            top: 50%;
            transform: translateY(-50%);
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            color: white;
            font-size: 24px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
        }

        .gallery-nav-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-50%) scale(1.1);
        }

        .gallery-nav-btn.prev { left: 20px; }
        .gallery-nav-btn.next { right: 20px; }

        .gallery-info {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
            color: white;
            padding: 30px 20px 20px;
            text-align: center;
            z-index: 10000;
        }

        .gallery-info h5 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .gallery-info p {
            margin: 0;
            opacity: 0.8;
        }

        .gallery-counter {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(10px);
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 500;
            z-index: 10000;
        }

        .card-img-wrapper {
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .card-img-wrapper img {
            transition: transform 0.3s ease;
        }

        .card-img-wrapper:hover img {
            transform: scale(1.1);
        }

        .card-img-wrapper::after {
            content: '\f002';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 48px;
            color: white;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .card-img-wrapper:hover::after {
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .gallery-nav-btn {
                width: 45px;
                height: 45px;
                font-size: 18px;
            }
            .gallery-close-btn {
                width: 40px;
                height: 40px;
                font-size: 20px;
            }
            .gallery-back-btn {
                padding: 10px 18px;
                font-size: 0.9rem;
            }
            .gallery-nav-btn.prev { left: 10px; }
            .gallery-nav-btn.next { right: 10px; }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container">
    <a href="../galeri.php?slug=<?= htmlspecialchars($parent_album['slug']) ?>" class="btn btn-outline-primary rounded-pill">
      <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>

    <span class="navbar-text fw-bold text-primary text-uppercase">Foto Sub Album</span>
  </div>
</nav>

<section class="py-5 bg-light">
    <?php if (isset($_GET['status'])): ?>
    <div class="container mt-3">
        <?php if ($_GET['status'] == 'success'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>Foto berhasil dihapus!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php elseif ($_GET['status'] == 'error'): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-times-circle me-2"></i>Gagal menghapus foto!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

  <div class="container">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-uppercase"><?= htmlspecialchars($subalbum['judul']) ?></h2>
        <p class="text-muted"><?= htmlspecialchars($subalbum['deskripsi']) ?></p>
    </div>

    <div class="d-flex justify-content-end mb-4">
        <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addFotoModal">
            <i class="fas fa-plus me-2"></i>Tambah Foto
        </button>
    </div>

    <div class="row">
        <?php if (count($all_photos) > 0): ?>
            <?php foreach ($all_photos as $index => $foto): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-img-wrapper" onclick="openGallery(<?= $index ?>)">
                            <img src="../<?= htmlspecialchars($foto['gambar']) ?>"
                                class="card-img-top"
                                style="object-fit:cover; height:220px;"
                                alt="<?= htmlspecialchars($foto['judul']) ?>">
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= htmlspecialchars($foto['judul']) ?></h5>
                            <p class="card-text small text-muted"><?= htmlspecialchars($foto['tanggal_upload']) ?></p>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteFotoModal<?= $foto['id'] ?>">
                                <i class="fas fa-trash me-1"></i>Hapus
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal Konfirmasi Hapus -->
                <div class="modal fade" id="deleteFotoModal<?= $foto['id'] ?>" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus foto "<strong><?= htmlspecialchars($foto['judul']) ?></strong>"?</p>
                        <p class="text-danger small"><i class="fas fa-info-circle me-1"></i>Tindakan ini tidak dapat dibatalkan!</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <a href="../pages/proses_hapus_foto_kegiatan.php?id=<?= $foto['id'] ?>&slug=<?= $slug ?>" class="btn btn-danger">Ya, Hapus</a>
                      </div>
                    </div>
                  </div>
                </div>
            <?php endforeach; ?> 
        <?php else: ?>
            <p class="text-center text-muted">Belum ada foto di sub-album ini.</p>
        <?php endif; ?>
    </div>
  </div>
</section>

<!-- Custom Gallery Modal -->
<div class="gallery-modal" id="galleryModal">
    <a href="../galeri.php?slug=<?= htmlspecialchars($parent_album['slug']) ?>" class="gallery-back-btn">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
    
    <div class="gallery-close-btn" onclick="closeGallery()">
        <i class="fas fa-times"></i>
    </div>
    
    <div class="gallery-counter" id="galleryCounter"></div>
    
    <div class="gallery-nav-btn prev" onclick="prevImage()">
        <i class="fas fa-chevron-left"></i>
    </div>
    
    <div class="gallery-modal-content">
        <img id="galleryImage" src="" alt="">
    </div>
    
    <div class="gallery-nav-btn next" onclick="nextImage()">
        <i class="fas fa-chevron-right"></i>
    </div>
    
    <div class="gallery-info">
        <h5 id="galleryTitle"></h5>
        <p id="galleryDate"></p>
    </div>
</div>

<!-- Modal Tambah Foto Kegiatan -->
<div class="modal fade" id="addFotoModal" tabindex="-1" aria-labelledby="addFotoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" enctype="multipart/form-data" action="../pages/proses_upload_foto.php">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="addFotoModalLabel"><i class="fas fa-image me-2"></i>Tambah Foto Kegiatan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="sub_album_id" value="<?= $subalbum['id'] ?>">
        <div class="mb-3">
            <label for="gambar_foto" class="form-label">File Foto</label>
            <input type="file" class="form-control" id="gambar_foto" name="gambar" accept="image/*" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Upload</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Data foto dari PHP
    const photos = <?= json_encode($all_photos) ?>;
    let currentIndex = 0;

    function openGallery(index) {
        currentIndex = index;
        updateGalleryImage();
        document.getElementById('galleryModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeGallery() {
        document.getElementById('galleryModal').classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    function nextImage() {
        currentIndex = (currentIndex + 1) % photos.length;
        updateGalleryImage();
    }

    function prevImage() {
        currentIndex = (currentIndex - 1 + photos.length) % photos.length;
        updateGalleryImage();
    }

    function updateGalleryImage() {
        const photo = photos[currentIndex];
        document.getElementById('galleryImage').src = '../' + photo.gambar;
        document.getElementById('galleryTitle').textContent = photo.judul;
        document.getElementById('galleryDate').textContent = photo.tanggal_upload;
        document.getElementById('galleryCounter').textContent = `${currentIndex + 1} / ${photos.length}`;
    }

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (!document.getElementById('galleryModal').classList.contains('active')) return;
        
        if (e.key === 'ArrowRight') nextImage();
        if (e.key === 'ArrowLeft') prevImage();
        if (e.key === 'Escape') closeGallery();
    });

    // Close on click outside
    document.getElementById('galleryModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeGallery();
        }
    });

    // Touch swipe support for mobile
    let touchStartX = 0;
    let touchEndX = 0;

    document.getElementById('galleryModal').addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
    });

    document.getElementById('galleryModal').addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });

    function handleSwipe() {
        if (touchEndX < touchStartX - 50) nextImage();
        if (touchEndX > touchStartX + 50) prevImage();
    }
</script>

</body>
</html>