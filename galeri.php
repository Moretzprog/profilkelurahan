<?php
include 'koneksi.php';

if (!isset($_GET['slug'])) {
    header('Location: index.php');
    exit;
}

$slug = mysqli_real_escape_string($koneksi, $_GET['slug']);
$query_album = "SELECT * FROM t_galeri WHERE slug = ? LIMIT 1";
$stmt_album = mysqli_prepare($koneksi, $query_album);
mysqli_stmt_bind_param($stmt_album, "s", $slug);
mysqli_stmt_execute($stmt_album);
$result_album = mysqli_stmt_get_result($stmt_album);
$album = mysqli_fetch_assoc($result_album);

if (!$album) {
    header('Location: index.php');
    exit;
}

$id_album = $album['id'];
$judul_album = htmlspecialchars($album['judul']);
$deskripsi_album = htmlspecialchars($album['deskripsi']);
$gambar_album = htmlspecialchars($album['gambar']);
$tanggal_upload = htmlspecialchars($album['tanggal_upload']);

$query_subalbum = "SELECT * FROM t_galeri WHERE parent_id = ? ORDER BY tanggal_upload DESC";
$stmt_subalbum = mysqli_prepare($koneksi, $query_subalbum);
mysqli_stmt_bind_param($stmt_subalbum, "i", $id_album);
mysqli_stmt_execute($stmt_subalbum);
$result_subalbum = mysqli_stmt_get_result($stmt_subalbum);
$total_subalbum = mysqli_num_rows($result_subalbum);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $deskripsi_album ?>">
    <title><?= $judul_album ?> - Sub Album</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    
    <style>
        .subalbum-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
        }

        .subalbum-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 3rem rgba(0,0,0,0.175);
        }

        .subalbum-card img {
            transition: transform 0.3s ease;
            object-fit: cover;
            height: 220px;
            width: 100%;
        }

        .subalbum-card:hover img {
            transform: scale(1.05);
        }

        .card-actions {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .subalbum-card:hover .card-actions {
            opacity: 1;
        }

        .btn-delete {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(220, 53, 69, 0.9);
            border: 2px solid white;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-delete:hover {
            background: #dc3545;
            transform: scale(1.1);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-state i {
            font-size: 5rem;
            color: #6c757d;
            opacity: 0.5;
            margin-bottom: 1.5rem;
        }

        .modal-delete .modal-content {
            border-radius: 15px;
            border: none;
        }

        .modal-delete .modal-header {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            border: none;
        }

        .image-preview {
            display: none;
            margin-top: 1rem;
            border-radius: 10px;
            overflow: hidden;
            max-height: 250px;
        }

        .image-preview img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <a href="index.php#galeri" class="btn btn-outline-primary rounded-pill">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
        <span class="navbar-text fw-bold text-primary text-uppercase">Sub Album</span>
    </div>
</nav>

<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
            <div>
                <h2 class="fw-bold text-uppercase mb-1"><?= $judul_album ?></h2>
                <p class="text-muted mb-0"><?= $deskripsi_album ?></p>
                <span class="badge bg-primary mt-2">
                    <i class="fas fa-folder me-1"></i><?= $total_subalbum ?> Sub Album
                </span>
            </div>
            <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addSubAlbumModal">
                <i class="fas fa-plus me-2"></i>Tambah Sub Album
            </button>
        </div>

        <div class="row" id="subalbumContainer">
            <?php if ($total_subalbum > 0): ?>
                <?php while ($sub = mysqli_fetch_assoc($result_subalbum)): ?>
                    <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="card subalbum-card h-100 shadow-sm">
                            <!-- Action Buttons -->
                            <div class="card-actions">
                                <button class="btn btn-delete" 
                                        onclick="confirmDelete(<?= $sub['id'] ?>, '<?= htmlspecialchars($sub['judul'], ENT_QUOTES) ?>')"
                                        title="Hapus Sub Album">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>

                            <div class="overflow-hidden">
                                <img src="<?= htmlspecialchars($sub['gambar']) ?>"
                                    class="card-img-top"
                                    alt="<?= htmlspecialchars($sub['judul']) ?>">
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title"><?= htmlspecialchars($sub['judul']) ?></h5>
                                <p class="card-text small text-muted"><?= htmlspecialchars($sub['deskripsi']) ?></p>
                                <a href="pages/kegiatan.php?slug=<?= $sub['slug'] ?>" 
                                   class="btn btn-outline-primary btn-sm rounded-pill">
                                   <i class="fas fa-images me-1"></i>Lihat Kegiatan
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="empty-state" data-aos="fade-up">
                        <i class="fas fa-folder-open"></i>
                        <h4 class="text-muted mb-3">Belum Ada Sub Album</h4>
                        <p class="text-muted">Mulai tambahkan sub album untuk album ini dengan klik tombol "Tambah Sub Album"</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Modal Tambah Sub Album -->
<div class="modal fade" id="addSubAlbumModal" tabindex="-1" aria-labelledby="addSubAlbumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" method="POST" enctype="multipart/form-data" action="pages/proses_add_sub_album.php" id="addSubAlbumForm">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addSubAlbumModalLabel">
                    <i class="fas fa-folder-plus me-2"></i>Tambah Sub Album Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="parent_id" value="<?= $id_album ?>">
                <div class="mb-3">
                    <label for="judul" class="form-label fw-bold">
                        <i class="fas fa-heading me-2"></i>Judul Sub Album
                    </label>
                    <input type="text" class="form-control" id="judul" name="judul" required placeholder="Masukkan judul sub album">
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label fw-bold">
                        <i class="fas fa-align-left me-2"></i>Deskripsi
                    </label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Masukkan deskripsi (opsional)"></textarea>
                </div>
                <div class="mb-3">
                    <label for="gambar" class="form-label fw-bold">
                        <i class="fas fa-image me-2"></i>Gambar Sampul
                    </label>
                    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
                    <div class="form-text">Format: JPG, PNG, GIF (Maks. 5MB)</div>
                </div>

                <div class="image-preview" id="imagePreview">
                    <img src="" alt="Preview" id="previewImg">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade modal-delete" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-trash-alt text-danger" style="font-size: 3rem;"></i>
                </div>
                <p class="text-center mb-0">Apakah Anda yakin ingin menghapus sub album:</p>
                <h5 class="text-center text-primary my-3" id="deleteSubAlbumName"></h5>
                <div class="alert alert-warning" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Perhatian!</strong> Semua foto dalam sub album ini juga akan terhapus dan tidak dapat dikembalikan.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="fas fa-trash-alt me-2"></i>Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
// Initialize AOS Animation
AOS.init({
    duration: 800,
    once: true,
    offset: 100
});

// Image Preview
document.getElementById('gambar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (file) {
        // Validasi ukuran file (5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran file terlalu besar! Maksimal 5MB');
            this.value = '';
            preview.style.display = 'none';
            return;
        }
        
        // Validasi tipe file
        if (!file.type.startsWith('image/')) {
            alert('File harus berupa gambar!');
            this.value = '';
            preview.style.display = 'none';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
});

// Reset form saat modal ditutup
document.getElementById('addSubAlbumModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('addSubAlbumForm').reset();
    document.getElementById('imagePreview').style.display = 'none';
});

// Delete Confirmation
let deleteSubAlbumId = null;

function confirmDelete(id, name) {
    deleteSubAlbumId = id;
    document.getElementById('deleteSubAlbumName').textContent = name;
    
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    if (deleteSubAlbumId) {
        // Tampilkan loading
        this.disabled = true;
        this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menghapus...';
        
        // Redirect ke halaman proses hapus
        window.location.href = 'pages/proses_hapus_subalbum.php?id=' + deleteSubAlbumId;
    }
});
</script>

</body>
</html>

<?php
mysqli_stmt_close($stmt_album);
mysqli_stmt_close($stmt_subalbum);
mysqli_close($koneksi);
?>