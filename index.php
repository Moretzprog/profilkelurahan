<?php
include 'koneksi.php';
// Pastikan session sudah dimulai di bagian atas file
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user sudah login
$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === TRUE;

// ambil data profil
$query = $koneksi->query("SELECT * FROM profil_kelurahan WHERE id = 1");
$data = $query->fetch_assoc();

if ($query && $query->num_rows > 0) {
    $data = $query->fetch_assoc();
} else {
    // Antisipasi jika data belum ada
    $data = [
        'deskripsi' => 'Belum ada data deskripsi.',
        'visi' => 'Belum ada data visi.',
        'misi' => 'Belum ada data misi.'
    ];
}

$q = $koneksi->query("SELECT * FROM profil_kelurahan WHERE id = 1");

if (!$q) {
    die("Query error: " . $koneksi->error);
}

$data = $q->fetch_assoc();

if (!$data) {
    die("Tidak ada baris dengan id=1 di tabel profil_kelurahan");
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kelurahan Sarijaya - Beranda</title>

    <link rel="stylesheet" href="css/style.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="css/maps.css">
    <link rel="stylesheet" href="css/main.css?<?= time() ?>">
    <!-- Swiper -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css"/>
    <!-- JavaScript -->
    <script src="js/maps.js"></script>

</head>

<body style="font-family: 'Outfit', sans-serif;">
<!-- ================ Navbar ================ -->
<nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-landmark me-2"></i>Kelurahan Sarijaya</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link active" href="#home">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#profil">Profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="#galeri">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link" href="#lembaga">Lembaga</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>

                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === TRUE): ?>
                    <li class="nav-item" id="status-user"><a class="nav-link"><i class="fas fa-user "></i></a></li>
                    <?php endif; ?>
                    
                    <?php if ($is_logged_in): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="pages/logout.php" onclick="return confirm('Apakah Anda yakin ingin keluar?');">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="pages/admin_login.php">
                                <i class="fas fa-user me-2"></i>
                                Admin
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
</nav>

<!-- ===============  Hero Section =============== -->
<section id="home" class="hero-section">
    <div class="container" data-aos="fade-up">
        <h1 class="display-4 fw-bold mb-3">Selamat Datang di Kelurahan Sarijaya</h1>
            <p class="lead mb-4">Membangun masyarakat yang maju, sejahtera, dan mandiri.</p>
                <!-- <a href="#profil" class="btn btn-light btn-lg rounded-pill shadow">Jelajahi <i class="fas fa-arrow-down ms-2"></i></a> -->
                 
                <a href="#profil" class="Btn-Container">
                    <span class="text">Jelajahi</span>
                        <span class="icon-Container">
                            <svg
                            width="16"
                            height="19"
                            viewBox="0 0 16 19"
                            fill="nones"
                            xmlns="http://www.w3.org/2000/svg"
                            >
                            <circle cx="1.61321" cy="1.61321" r="1.5" fill="black"></circle>
                            <circle cx="5.73583" cy="1.61321" r="1.5" fill="black"></circle>
                            <circle cx="5.73583" cy="5.5566" r="1.5" fill="black"></circle>
                            <circle cx="9.85851" cy="5.5566" r="1.5" fill="black"></circle>
                            <circle cx="9.85851" cy="9.5" r="1.5" fill="black"></circle>
                            <circle cx="13.9811" cy="9.5" r="1.5" fill="black"></circle>
                            <circle cx="5.73583" cy="13.4434" r="1.5" fill="black"></circle>
                            <circle cx="9.85851" cy="13.4434" r="1.5" fill="black"></circle>
                            <circle cx="1.61321" cy="17.3868" r="1.5" fill="black"></circle>
                            <circle cx="5.73583" cy="17.3868" r="1.5" fill="black"></circle>
                            </svg>
                        </span>
                    </a>
    </div>
</section>

<!-- ============ Profil ============ -->
<section id="profil" class="py-5">
  <div class="container">
    <h2 class="section-title" data-aos="fade-up">Profil Kelurahan Sarijaya</h2>

    <div class="row align-items-center g-3 mb-4">
      <!-- Deskripsi, Visi, Misi -->
      <div class="col-md-6" data-aos="fade-right">
        <?php if ($is_logged_in): ?>
          <button class="btn btn-sm btn-outline-secondary position-absolute top-0 end-0 mt-2 me-2 shadow-sm"
            style="z-index: 10;"
            data-bs-toggle="modal" data-bs-target="#editContentModal"
            title="Edit Deskripsi dan Visi Misi">
            <i class="fas fa-edit me-1"></i> Edit Teks
          </button>
        <?php endif; ?>

        <br><br>
        <p class="lead" id="kelurahan-description"><?= nl2br($data['deskripsi']); ?></p>
        <strong><i><p id="kelurahan-vision">Visi:<?= nl2br($data['visi']); ?></p></i></strong>
        <strong><i><p id="kelurahan-mission">Misi:<?= nl2br($data['misi']); ?></p></i></strong>    
      </div>

      <!-- Struktur Organisasi -->
      <div class="col-md-6" data-aos="fade-left">
        <div class="card-body p-4 text-center">
          <div class="position-relative mb-3">
            <img src="<?= !empty($data['struktur_gambar']) ? $data['struktur_gambar'] : 'https://placehold.co/600x400/007bff/ffffff?text=Struktur+Organisasi' ?>"
              class="img-fluid rounded-4 border border-3 border-white shadow"
              alt="Struktur Organisasi"
              style="max-height:320px; object-fit:cover;"
              id="organizational-structure-image">

            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === TRUE): ?>
              <button class="btn btn-light btn-sm border border-3 border-dark rounded-circle position-absolute bottom-0 end-0 translate-middle shadow-lg"
                style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; z-index: 1;"
                data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah Gambar"
                onclick="document.getElementById('image-upload-input').click();">
                <i class="fas fa-camera text-primary"></i>
              </button>
            <?php endif; ?>

            <input type="file" id="image-upload-input" style="display: none;" accept="image/*">
            <span class="position-absolute top-0 start-50 translate-middle badge rounded-pill bg-light text-primary shadow"
              style="font-size:1.1rem; letter-spacing:1px;">
              <i class="fas fa-sitemap me-2"></i>Struktur Organisasi
            </span>
          </div>
          <p class="fw-semibold text-white mb-0">Struktur Organisasi Kelurahan Sarijaya</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Modal Edit -->
<div class="modal fade" id="editContentModal" tabindex="-1" aria-labelledby="editContentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-pencil-alt me-2"></i>Edit Konten Kelurahan Sarijaya</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <div class="mb-3">
                        <label for="editDescription" class="form-label fw-bold">Deskripsi Kelurahan</label>
                        <textarea class="form-control" id="editDescription" rows="4"><?= $data['deskripsi']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editVision" class="form-label fw-bold">Visi</label>
                        <textarea class="form-control" id="editVision" rows="2"><?= $data['visi']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editMission" class="form-label fw-bold">Misi</label>
                        <textarea class="form-control" id="editMission" rows="3"><?= $data['misi']; ?></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="saveBtn">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>
<!-- ==================== Peta Wilayah ==================== -->
<h3 class="section-title mt-5 text-center" data-aos="zoom-in">
    <i class="fas fa-map-marked-alt me-2 text-primary"></i>Peta Wilayah Kelurahan Sarijaya
</h3>
<div class="d-flex justify-content-center align-items-center my-4">
    <div class="card shadow-lg border-0" style="max-width: 800px; width: 100%; background: linear-gradient(135deg, #f8fafc 80%, #e0f7fa 100%);">
        <div class="card-body p-0">
            <div class="ratio ratio-16x9 rounded-4 overflow-hidden">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15932.231057623476!2d117.0793836!3d-0.4693394!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df67b3fa697ed01%3A0x46bd8e1e44a2ef3d!2sSarijaya%2C%20Kec.%20Sanga-Sanga%2C%20Kabupaten%20Kutai%20Kartanegara%2C%20Kalimantan%20Timur!5e0!3m2!1sid!2sid!4v1720402557581!5m2!1sid!2sid"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            <div class="text-center py-3">
                <span class="color-primary badge bg-gradient rounded-pill px-4 py-2 shadow-sm" style="background: linear-gradient(90deg, #007bff 60%, #28a745 100%); font-size: 1.1rem; color: black;">
                    <i class="fas fa-map-pin me-2" style="color:#dc3545;"></i>Peta Administrasi Kelurahan Sarijaya
                </span>
            </div>
        </div>
    </div>
</div>

<!-- ==================== Peta Sumber Daya Alam dan Sarana Prasarana || Tab Navigation ==================== -->
<ul class="nav nav-pills nav-justified my-4 bg-white shadow-sm rounded-4" id="customTab" role="tablist" style="max-width: 600px; margin: 0 auto;">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="sda-tab" data-file="sda.html" type="button" role="tab">
            <i class="fas fa-seedling me-2" style="color:#29DC52FF;"></i>Peta Sumber Daya Alam
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="sapras-tab" data-file="sapras.html" type="button" role="tab">
            <i class="fas fa-building me-2"></i>Peta Sarana Prasarana
        </button>
    </li>
</ul>
<!-- ==================== Tab Content Container ==================== -->
<div class="tab-content-container">
    <div id="tab-content-dinamis" class="tab-pane fade show active">
        <div class="loading-spinner">
            <i class="fas fa-spinner text-primary"></i>
            <p class="text-muted mt-2">Memuat konten...</p>
        </div>
    </div>
</div>
</section>

<!-- ==================== Galeri ==================== -->
<section id="galeri" class="py-5 bg-light">
        <div class="container container-box">
            <h2 class="section-title text-center mb-5" data-aos="fade-up">Galeri Foto Kegiatan</h2>

            <div class="row mb-4 align-items-center">
                <div class="col-md-6 mb-3 mb-md-0" data-aos="fade-up" data-aos-delay="50">
                    <div class="input-group">
                        <!-- ============= Button Buat Album Baru ================ -->
                         <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === TRUE) : ?>
                        <button class="btn btn-success rounded-pill me-2 shadow-sm"
                            type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#createAlbumModal"
                            title="Buat Album Baru">
                            <i class="fas fa-plus me-1"></i> Album
                        </button>
                        <?php endif; ?>
                        <!-- ============= Search Album ============ -->
                        <input type="text" class="form-control rounded-pill" placeholder="" style="transition: all 0.3s ease;" id="gallery-search">
                        <button class="btn btn-primary rounded-pill ms-2" type="button" style="width: 50px;">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <!-- =============== Filter Galeri ============== -->
                <div class="col-md-6 text-md-end" data-aos="fade-up" data-aos-delay="150">
                    <span class="fw-bold me-2 d-none d-sm-inline">Filter:</span>
                    <div class="btn-group" role="group" aria-label="Filter Galeri">
                        <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill me-1" data-tag="semua">Semua</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill me-1" data-tag="rutin">Rutin</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill me-1" data-tag="edukasi">Edukasi</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill" data-tag="nasional">Nasional</button>
                    </div>
                </div>
            </div>
<!-- ===================== Konten Galeri ================== -->
            <div class="swiper mySwiper" id="gallery-albums">
                <div class="swiper-wrapper">
                    <?php
                    include 'koneksi.php';
                    $query = "SELECT * FROM t_galeri ORDER BY tanggal_upload DESC";
                    $result = mysqli_query($koneksi, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $judul = htmlspecialchars($row['judul']);
                        $deskripsi = htmlspecialchars($row['deskripsi']);
                        $gambar = htmlspecialchars($row['gambar']);
                        $kategori = htmlspecialchars($row['kategori']);
                        $slug = htmlspecialchars($row['slug']);
                    ?>
                    <div class="swiper-slide album-item" data-aos="fade-up" data-tags="<?= $kategori ?>">
                        <div class="card h-100 shadow-sm border-0 position-relative">
                        <!-- ============== Button Aksi ============= -->
                        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === TRUE): ?>
                            <div class="position-absolute top-0 end-0 m-2 z-3 d-flex gap-1">
                            <button class="btn btn-sm btn-light text-primary rounded-circle shadow-sm" 
                                    title="Edit Album" 
                                    onclick="editAlbum(<?= $row['id'] ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-light text-danger rounded-circle shadow-sm" 
                                    title="Hapus Album" 
                                    onclick="deleteAlbum(<?= $row['id'] ?>)">
                                <i class="fas fa-trash"></i>
                            </button>
                            </div>
                        <?php endif; ?>

                        <img src="<?= $gambar ?>" class="card-img-top" alt="<?= $judul ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= $judul ?></h5>
                            <p class="card-text"><?= $deskripsi ?></p>
                            <a href="galeri.php?slug=<?= $slug ?>" class="btn btn-outline-primary btn-sm rounded-pill">Lihat Album</a>
                        </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>

            <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="300">
                <a href="galeri.php" class="btn btn-primary btn-lg rounded-pill shadow-sm px-5">
                    <i class="fas fa-images me-2"></i> Lihat Semua Galeri
                </a>
            </div>
        </div>
</section>

<!-- =================== Modal Buat Album Baru ================= -->
<div class="modal fade" id="createAlbumModal" tabindex="-1" aria-labelledby="createAlbumLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <div class="modal-header bg-primary text-white rounded-top-4">
        <h5 class="modal-title" id="createAlbumLabel"><i class="fas fa-plus me-2"></i> Tambah Album Baru</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="albumForm" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="mb-3">
            <label for="judul" class="form-label">Judul Album</label>
            <input type="text" class="form-control rounded-pill" id="judul" name="judul" required>
          </div>

          <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control rounded-3" id="deskripsi" name="deskripsi" rows="3" required></textarea>
          </div>

          <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <select class="form-select rounded-pill" id="kategori" name="kategori" required>
              <option value="rutin">Rutin</option>
              <option value="edukasi">Edukasi</option>
              <option value="nasional">Nasional</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="gambar" class="form-label">Gambar Album</label>
            <input type="file" class="form-control rounded-pill" id="gambar" name="gambar" accept="image/*" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary rounded-pill">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- =================== End Modal Buat Album Baru ================= -->

<!-- =================== Modal Edit Album ================= -->
<div class="modal fade" id="editAlbumModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Album</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="editAlbumForm" enctype="multipart/form-data">
          <input type="hidden" id="editAlbumId" name="id">

          <div class="mb-3">
            <label for="editJudul" class="form-label">Judul Album</label>
            <input type="text" class="form-control" id="editJudul" name="judul" required>
          </div>

          <div class="mb-3">
            <label for="editDeskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="editDeskripsi" name="deskripsi" rows="3" required></textarea>
          </div>

            <div class="text-center mb-3">
                <label for="editGambar" class="form-label">Gambar Sebelumnya</label>
                <img id="preview-gambar-lama" src="" alt="Gambar Lama"
               class="img-fluid rounded shadow-sm" style="max-height: 200px;">
            </div>

          <div class="mb-3">
            <label for="editGambar" class="form-label">Ganti Gambar (opsional)</label>
            <input type="file" class="form-control" id="editGambar" name="gambar" accept="image/*">
          </div>

          <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- =================== End Modal Edit Album ================ -->


<!-- =================== Lembaga-lembaga ================ -->
    <section id="lembaga" class="py-5">
        <div class="container container-box">
            <h2 class="section-title" data-aos="fade-up">Sektor Lembaga Kelurahan Sarijaya</h2>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 justify-content-center">

                <!-- Posyandu -->
                <div class="col" data-aos="zoom-in">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="fas fa-child fa-3x text-info mb-3"></i>
                            <h5 class="card-title">Posyandu</h5>
                            <p class="card-text">Pusat pelayanan kesehatan ibu dan anak, imunisasi, serta penyuluhan gizi.</p>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="#" class="btn btn-info rounded-pill">Preview</a>
                                <a href="#" class="btn opacity-50 rounded-pill disabled" tabindex="-1" aria-disabled="true">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Keamanan -->
                <div class="col" data-aos="zoom-in" data-aos-delay="100">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="fas fa-shield-alt fa-3x text-warning mb-3"></i>
                            <h5 class="card-title">Keamanan</h5>
                            <p class="card-text">Menjaga ketertiban dan keamanan lingkungan kelurahan.</p>
                            <a href="#" class="btn btn-outline-warning rounded-pill">Detail</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Kontak -->
    <section id="kontak" class="py-5 bg-dark text-white text-center">
        <div class="container position-relative" data-aos="fade-up">

            <button class="btn btn-sm btn-outline-light position-absolute top-0 end-0 mt-2 me-2 shadow-sm"
                style="z-index: 10;"
                data-bs-toggle="modal"
                data-bs-target="#editContactModal"
                title="Edit Informasi Kontak">
                <i class="fas fa-edit me-1"></i> Edit
            </button>
            <h2 class="section-title text-white">Hubungi Kami</h2>
            <p class="lead text-white">Untuk informasi lebih lanjut, silakan hubungi:</p>

            <p class="text-white" id="contact-address"><i class="fas fa-map-marker-alt me-2"></i> Jl. Kelurahan Sarijaya No. 123</p>
            <p class="text-white" id="contact-phone"><i class="fas fa-phone me-2"></i> (021) 12345678</p>
            <p class="text-white" id="contact-email"><i class="fas fa-envelope me-2"></i> info@sarijaya.go.id</p>
        </div>

        <div class="modal fade" id="editContactModal" tabindex="-1" aria-labelledby="editContactModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="editContactModalLabel"><i class="fas fa-edit me-2"></i>Edit Informasi Kontak</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="contactForm">
                            <div class="mb-3">
                                <label for="inputAddress" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="inputAddress" value="Jl. Kelurahan Sarijaya No. 123" required>
                            </div>
                            <div class="mb-3">
                                <label for="inputPhone" class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control" id="inputPhone" value="(021) 12345678" required>
                            </div>
                            <div class="mb-3">
                                <label for="inputEmail" class="form-label">Alamat Email</label>
                                <input type="email" class="form-control" id="inputEmail" value="info@sarijaya.go.id" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" onclick="saveContactChanges()">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kotak Saran -->
        <div class="container mt-5" data-aos="fade-up" data-aos-delay="100">
            <div class="card bg-gradient bg-opacity-75 border-0 shadow-lg mx-auto" style="max-width: 700px; background: linear-gradient(135deg, #007bff 60%, #28a745 100%);">
                <div class="card-body p-4">
                    <h4 class="text-white mb-4 text-center"><i class="fas fa-comment-dots me-2"></i>Kotak Saran</h4>
                    <form class="row g-3 justify-content-center text-start">
                        <div class="col-md-6">
                            <label for="nama" class="form-label text-white fw-semibold">Nama</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-0"><i class="fas fa-user text-primary"></i></span>
                                <input type="text" class="form-control rounded-end" id="nama" placeholder="Nama Anda">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label text-white fw-semibold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-0"><i class="fas fa-envelope text-success"></i></span>
                                <input type="email" class="form-control rounded-end" id="email" placeholder="email@contoh.com">
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="pesan" class="form-label text-white fw-semibold">Pesan / Saran</label>
                            <textarea class="form-control rounded-3" id="pesan" rows="4" placeholder="Tulis saran Anda di sini..." style="resize:none"></textarea>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-light px-5 rounded-pill mt-3 shadow-sm">
                                <i class="fas fa-paper-plane me-2 text-primary"></i>Kirim
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


    <!-- Modal Kotak Saran -->
    <div class="modal fade" id="saranModal" tabindex="-1" aria-labelledby="saranModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="saranModalLabel"><i class="fas fa-inbox me-2"></i> Pesan Saran Pengunjung</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <!-- Daftar Pesan -->
                    <div class="list-group">
                        <!-- Contoh data statis, nanti diganti dengan loop PHP -->
                        <div class="list-group-item">
                            <h6 class="mb-1">Arif <small class="text-muted">20 Sept 2025</small></h6>
                            <p class="mb-1">Website ini sangat membantu warga. Terima kasih!</p>
                        </div>
                        <div class="list-group-item">
                            <h6 class="mb-1">Siti <small class="text-muted">21 Sept 2025</small></h6>
                            <p class="mb-1">Mungkin bisa ditambahkan fitur informasi beasiswa.</p>
                        </div>
                        <!-- dst... -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 Kelurahan Sarijaya. Hak Cipta Dilindungi.</p>
            <p>Dibuat dengan <i class="fas fa-heart text-danger"></i> oleh warga Sarijaya.</p>
        </div>
    </footer>

<!-- ========= HELPER ========== -->
    <!-- Saran -->
    <div id="saranBtn" class="btn btn-success rounded-circle shadow-lg"
        style="position: fixed; bottom: 20px; right: 20px; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; z-index: 1050;"
        data-bs-toggle="modal" data-bs-target="#saranModal">
        <i class="fas fa-comment-dots fs-4"></i>
    </div>

    <!-- Back to Top -->
    <button id="backToTop" class="btn btn-primary rounded-circle shadow"
        style="position: fixed; bottom: 160px; right: 20px; width: 50px; height: 50px; display: none; z-index: 1049;">
        <i class="fas fa-arrow-up"></i>
    </button>



<!-- =============== SCRIPT =============== -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Lightbox JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Swiper -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="js/main.js?<?= time() ?>"></script>
</body>

</html>