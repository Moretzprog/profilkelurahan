<?php 
include 'koneksi.php';

// ngecek kalo slug ga terkirim
if (!isset($_GET['slug'])) {
    echo 'Album tidak ditemukan';
    exit;
}

$slug = mysqli_real_escape_string($koneksi, $_GET['slug']); // amankan input

$query = "SELECT * FROM t_galeri WHERE slug = '$slug'";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) == 0) {
    echo "Album tidak ditemukan";
    exit;
}

$galeri = mysqli_fetch_assoc($result); // bisa pakai fetch_assoc lebih aman
$judul_album = htmlspecialchars($galeri['judul']);
$deskripsi_album = htmlspecialchars($galeri['deskripsi']);
$gambar_album = htmlspecialchars($galeri['gambar']);
$kategori_album = htmlspecialchars($galeri['kategori']);
$tanggal_upload = htmlspecialchars($galeri['tanggal_upload']);
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- AOS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <!-- Lightbox -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <!-- CSS Custom -->
     <link rel="stylesheet" href="css/galeri.css">
    <title>Galeri Gotong Royong</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-primary bg-white shadow-sm sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 text-primary fw-bold kembali-btn" href="index.php"
                style="font-size:1.2rem;">
                <span
                    class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center kembali-icon"
                    style="width:36px;height:36px; transition: background 0.3s, transform 0.3s;">
                    <i class="fas fa-arrow-left"></i>
                </span>
                Kembali ke Beranda
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-primary fw-semibold" href="#"><i
                                class="fas fa-images me-1"></i>Galeri Lainnya</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary fw-semibold" href="../kontak.html"><i
                                class="fas fa-envelope me-1"></i>Kontak</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5 d-flex justify-content-between align-items-center">
                <h2 class="section-title mb-0"><?php echo $judul_album; ?></h2>
                <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addGalleryModal">
                    <i class="fas fa-plus me-2"></i>Tambah Kegiatan
                </button>
                </div>

            <div class="row mb-4 justify-content-center">
                <div class="col-md-3 mb-2">
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari kegiatan...">
                </div>
                <div class="col-md-3 mb-2">
                    <input type="month" id="filterMonth" class="form-control">
                </div>
                <div class="col-md-6 mb-2 d-flex flex-wrap align-items-center justify-content-center gap-2">
                    <span class="fw-semibold me-2">Filter Tag:</span>
                    <button type="button" class="btn btn-outline-warning btn-sm filter-tag-btn active"
                        data-tag="">Semua</button>
                    <button type="button" class="btn btn-outline-warning btn-sm filter-tag-btn" data-tag="Drainase">
                        <i class="fas fa-water me-1"></i> Drainase
                    </button>
                    <button type="button" class="btn btn-outline-info btn-sm filter-tag-btn" data-tag="Lingkungan">
                        <i class="fas fa-leaf me-1"></i> Lingkungan
                    </button>
                    <button type="button" class="btn btn-outline-purple btn-sm filter-tag-btn" data-tag="Kebersihan"
                        style="--bs-btn-color: #8A2BE2; --bs-btn-border-color: #8A2BE2;">
                        <i class="fas fa-broom me-1"></i> Kebersihan
                    </button>
                </div>
            </div>


            <div class="row" id="galleryContainer">
                                <div class="col-md-4 mb-4">
                      <div class="card gallery-card border-0 shadow-lg h-100 position-relative" 
                          data-title="Pembersihan Drainase"
                          data-date="2025-06" 
                          data-tag-display="Drainase"
                          data-id="gallery-123"
                          style="overflow:hidden; transition: transform 0.3s;">
                          
                          <div class="position-absolute top-0 end-0 m-2 z-3 d-flex gap-1">
                              <button class="btn btn-sm btn-light text-primary rounded-circle shadow-sm" 
                                      title="Edit Item"
                                      data-bs-toggle="modal" 
                                      data-bs-target="#editGalleryModal" 
                                      onclick="editItem('gallery-123')">
                                  <i class="fas fa-edit"></i>
                              </button>
                              
                              <button class="btn btn-sm btn-light text-danger rounded-circle shadow-sm" 
                                      title="Hapus Item"
                                      onclick="deleteItem('gallery-123')">
                                  <i class="fas fa-trash-alt"></i>
                              </button>
                          </div>
                          <a href="https://placehold.co/800x600/FFD700/000000?text=Gotong+Royong+1" data-lightbox="gotong"
                              data-title="Pembersihan Drainase" class="d-block position-relative">
                              <img src="<?php echo $gambar_album; ?>"
                                  class="card-img-top img-fluid rounded-top"
                                  style="object-fit:cover; height:220px; transition: transform 0.3s;">
                              <span
                                  class="gallery-tag badge bg-warning text-dark position-absolute top-0 start-0 m-2 px-3 py-2 shadow-sm"
                                  style="font-size:0.9rem; letter-spacing:1px;">Drainase</span>
                              <span class="position-absolute top-50 start-50 translate-middle opacity-0 hover-overlay"
                                  style="transition: opacity 0.3s;">
                                  <i class="fas fa-search-plus fa-2x text-white bg-dark bg-opacity-75 rounded-circle p-3"></i>
                              </span>
                          </a>
                          <div class="card-body bg-white">
                              <h5 class="card-title fw-bold text-primary mb-2"><?php echo $judul_album; ?></h5>
                              <p class="card-text text-muted mb-1"><i class="far fa-calendar-alt me-1"></i> <?php echo $tanggal_upload; ?></p>
                              <p class="card-text small"><?php echo $deskripsi_album; ?></p>
                          </div>
                      </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card gallery-card border-0 shadow-lg h-100" data-title="Pemangkasan Pohon"
                        data-date="2025-07" data-tag-display="Lingkungan"
                        style="overflow:hidden; transition: transform 0.3s;">
                        <a href="https://placehold.co/800x600/20B2AA/ffffff?text=Gotong+Royong+2" data-lightbox="gotong"
                            data-title="Pemangkasan Pohon" class="d-block position-relative">
                            <img src="https://placehold.co/400x250/20B2AA/ffffff?text=Gotong+Royong+2"
                                class="card-img-top img-fluid rounded-top"
                                style="object-fit:cover; height:220px; transition: transform 0.3s;">
                            <span
                                class="gallery-tag badge bg-info text-white position-absolute top-0 start-0 m-2 px-3 py-2 shadow-sm"
                                style="font-size:0.9rem; letter-spacing:1px;">Lingkungan</span>
                            <span class="position-absolute top-50 start-50 translate-middle opacity-0 hover-overlay"
                                style="transition: opacity 0.3s;">
                                <i class="fas fa-search-plus fa-2x text-white bg-dark bg-opacity-75 rounded-circle p-3"></i>
                            </span>
                        </a>
                        <div class="card-body bg-white">
                            <h5 class="card-title fw-bold text-info mb-2">Pemangkasan Pohon</h5>
                            <p class="card-text text-muted mb-1"><i class="far fa-calendar-alt me-1"></i> Juli 2025</p>
                            <p class="card-text small">Pemangkasan pohon di sekitar jalan untuk menjaga keamanan dan
                                keindahan lingkungan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card gallery-card border-0 shadow-lg h-100" data-title="Pengangkutan Sampah"
                        data-date="2025-05" data-tag-display="Kebersihan"
                        style="overflow:hidden; transition: transform 0.3s;">
                        <a href="https://placehold.co/800x600/8A2BE2/ffffff?text=Gotong+Royong+3" data-lightbox="gotong"
                            data-title="Pengangkutan Sampah" class="d-block position-relative">
                            <img src="https://placehold.co/400x250/8A2BE2/ffffff?text=Gotong+Royong+3"
                                class="card-img-top img-fluid rounded-top"
                                style="object-fit:cover; height:220px; transition: transform 0.3s;">
                            <span
                                class="gallery-tag badge bg-purple text-white position-absolute top-0 start-0 m-2 px-3 py-2 shadow-sm"
                                style="background:#8A2BE2; font-size:0.9rem; letter-spacing:1px;">Kebersihan</span>
                            <span class="position-absolute top-50 start-50 translate-middle opacity-0 hover-overlay"
                                style="transition: opacity 0.3s;">
                                <i class="fas fa-search-plus fa-2x text-white bg-dark bg-opacity-75 rounded-circle p-3"></i>
                            </span>
                        </a>
                        <div class="card-body bg-white">
                            <h5 class="card-title fw-bold text-purple mb-2" style="color:#8A2BE2;">Pengangkutan Sampah
                            </h5>
                            <p class="card-text text-muted mb-1"><i class="far fa-calendar-alt me-1"></i> Mei 2025</p>
                            <p class="card-text small">Pengangkutan sampah bersama warga untuk menciptakan lingkungan
                                yang sehat dan nyaman.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <footer class="footer bg-dark text-white text-center py-3">
        <div class="container">
            <p class="mb-0">&copy; 2025 Kelurahan Sarijaya. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <div class="modal fade" id="addGalleryModal" tabindex="-1" aria-labelledby="addGalleryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addGalleryModalLabel"><i class="fas fa-image me-2"></i>Tambah Item Galeri Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addGalleryForm" enctype="multipart/form-data"> <div class="mb-3">
                        <label for="inputGambar" class="form-label">Gambar Kegiatan</label>
                        <input type="file" class="form-control" id="inputGambar" name="gambar" accept="image/*" required>
                        <div class="form-text">Pilih file gambar (JPG, PNG) untuk item galeri.</div>
                    </div>
                    <div class="mb-3">
                        <label for="inputJudul" class="form-label">Judul Kegiatan</label>
                        <input type="text" class="form-control" id="inputJudul" name="judul" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputTanggal" class="form-label">Bulan dan Tahun Kegiatan</label>
                        <input type="month" class="form-control" id="inputTanggal" name="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputTag" class="form-label">Tag Kategori</label>
                        <select class="form-select" id="inputTag" name="tag" required>
                            <option value="">Pilih Tag</option>
                            <option value="Drainase" data-color="bg-warning text-dark">Drainase</option>
                            <option value="Lingkungan" data-color="bg-info text-white">Lingkungan</option>
                            <option value="Kebersihan" data-color="bg-purple text-white">Kebersihan</option>
                            <option value="Lainnya" data-color="bg-secondary text-white">Lainnya</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" form="addGalleryForm">Simpan Galeri</button>
            </div>
        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script>
        const searchInput = document.getElementById('searchInput');
        const filterMonth = document.getElementById('filterMonth');
        const galleryItems = document.querySelectorAll('.gallery-card'); // Note: This will be updated to include galleryContainer's items
        const tagButtons = document.querySelectorAll('.filter-tag-btn');
        const galleryContainer = document.getElementById('galleryContainer');
        
        let selectedTag = '';

        // Fungsi untuk mendapatkan nama bulan dari format 'YYYY-MM'
        function formatMonth(dateString) {
            if (!dateString) return 'Tanggal tidak diketahui';
            const [year, month] = dateString.split('-');
            const date = new Date(year, month - 1);
            return date.toLocaleDateString('id-ID', {
                year: 'numeric',
                month: 'long'
            });
        }

        // Fungsi utama untuk filter dan pencarian
        function filterGallery() {
            const search = searchInput.value.toLowerCase();
            const selectedMonth = filterMonth.value;
            // Ambil semua item galeri saat ini di dalam kontainer
            const currentItems = galleryContainer.querySelectorAll('.gallery-card');

            currentItems.forEach(item => {
                const title = item.dataset.title.toLowerCase();
                const date = item.dataset.date;
                // Ambil tag dari data-tag-display
                const tag = item.dataset.tagDisplay || '';

                const matchSearch = title.includes(search);
                const matchDate = !selectedMonth || date.startsWith(selectedMonth);
                // Logika filter tag: kosong ('') berarti "Semua"
                const matchTag = !selectedTag || tag === selectedTag;

                // Terapkan filter
                const isMatch = matchSearch && matchDate && matchTag;
                item.parentElement.style.display = isMatch ? 'block' : 'none';
            });
        }

        // Listener untuk pencarian dan filter bulan
        searchInput.addEventListener('input', filterGallery);
        filterMonth.addEventListener('input', filterGallery);


        // Tag filter logic
        tagButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                tagButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                selectedTag = this.dataset.tag; // Atur selectedTag ke nilai data-tag
                filterGallery();
            });
        });

        // Set 'Semua' sebagai aktif saat halaman dimuat
        document.addEventListener('DOMContentLoaded', () => {
             document.querySelector('.filter-tag-btn[data-tag=""]').classList.add('active');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>