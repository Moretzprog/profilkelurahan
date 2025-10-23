<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include '../koneksi.php';
session_start();

if (!isset($_GET['slug']) || empty($_GET['slug'])) {
    echo "<p>Album tidak ditemukan.</p>";
    exit;
}

$slug = mysqli_real_escape_string($koneksi, $_GET['slug']);

// Take album induk berdasarkan slug
$query_album = "SELECT * FROM t_galeri WHERE slug = '$slug' LIMIT 1";
$result_album = mysqli_query($koneksi, $query_album);

if (!$result_album || mysqli_num_rows($result_album) === 0) {
    echo "<p>Album tidak ditemukan.</p>";
    exit;
}

$album = mysqli_fetch_assoc($result_album);
$id_album = (int)$album['id'];
$judul_album = $album['judul'];
$deskripsi_album = $album['deskripsi'];

// === Proses add subalbum AJAX ===
if (isset($_POST['ajax_submit'])) {
    header('Content-Type: application/json');
    
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $tanggal = date('Y-m-d H:i:s');

    $gambar = "";
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $nama_file = time() . "_" . basename($_FILES['gambar']['name']);
        $target_dir = "../uploads/";
        $target_file = $target_dir . $nama_file;
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            $gambar = "uploads/" . $nama_file;
        }
    }

    $slug_baru = strtolower(preg_replace('/[^a-z0-9]+/i', '-', trim($judul))) . '-' . time();

    $query_insert = "INSERT INTO t_galeri (judul, deskripsi, gambar, slug, parent_id, tanggal_upload)
                     VALUES ('$judul', '$deskripsi', '$gambar', '$slug_baru', $id_album, '$tanggal')";
    $insert = mysqli_query($koneksi, $query_insert);

    if ($insert) {
        echo json_encode([
            'success' => true,
            'id' => mysqli_insert_id($koneksi),
            'judul' => $judul,
            'deskripsi' => $deskripsi,
            'gambar' => $gambar,
            'slug' => $slug_baru
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => mysqli_error($koneksi)
        ]);
    }
    exit;
}

// === Proses hapus subalbum AJAX ===
if (isset($_POST['hapus_subalbum'])) {
    header('Content-Type: application/json');
    
    $id_subalbum = (int)$_POST['id'];
    
    // Ambil data gambar untuk dihapus
    $query_get = "SELECT gambar FROM t_galeri WHERE id = $id_subalbum AND parent_id = $id_album LIMIT 1";
    $result_get = mysqli_query($koneksi, $query_get);
    
    if ($result_get && mysqli_num_rows($result_get) > 0) {
        $data = mysqli_fetch_assoc($result_get);
        $gambar_path = "../" . $data['gambar'];
        
        // Hapus dari database
        $query_delete = "DELETE FROM t_galeri WHERE id = $id_subalbum AND parent_id = $id_album";
        $delete = mysqli_query($koneksi, $query_delete);
        
        if ($delete) {
            // Hapus file gambar jika ada
            if (!empty($data['gambar']) && file_exists($gambar_path)) {
                unlink($gambar_path);
            }
            
            echo json_encode([
                'success' => true,
                'message' => 'Sub album berhasil dihapus'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => mysqli_error($koneksi)
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Sub album tidak ditemukan'
        ]);
    }
    exit;
}

$query_subalbum = "SELECT * FROM t_galeri WHERE parent_id = $id_album ORDER BY tanggal_upload DESC";
$result_subalbum = mysqli_query($koneksi, $query_subalbum);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($judul_album) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <style>
        .card-actions {
            position: absolute;
            top: 10px;
            right: 10px;
            display: none;
        }
        .card:hover .card-actions {
            display: block;
        }
        .btn-delete {
            background-color: rgba(220, 53, 69, 0.9);
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-delete:hover {
            background-color: rgba(220, 53, 69, 1);
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a href="../index.php#galeri" class="btn btn-outline-primary rounded-pill">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
            <span class="navbar-text fw-bold text-primary text-uppercase">Foto Sub Album</span>
        </div>
    </nav>

<div class="container py-5">
    <div class="d-flex justify-content-end mb-4">
      <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahSubAlbumModal">
        <i class="fas fa-plus me-2"></i>Tambah Sub Album
      </button>
    </div>

    <div class="mb-4">
      <h2 class="fw-bold text-uppercase"><?= htmlspecialchars($judul_album) ?></h2>
      <p class="text-muted"><?= htmlspecialchars($deskripsi_album) ?></p>
    </div>

    <div class="row" id="subalbumContainer">
      <?php if ($result_subalbum && mysqli_num_rows($result_subalbum) > 0): ?>
        <?php while ($sub = mysqli_fetch_assoc($result_subalbum)): ?>
          <div class="col-md-4 mb-4" data-id="<?= $sub['id'] ?>">
            <div class="card h-100 shadow-sm border-0 position-relative">
              <div class="card-actions">
                <button class="btn-delete" onclick="hapusSubAlbum(<?= $sub['id'] ?>, '<?= htmlspecialchars($sub['judul']) ?>')">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
              <img src="../<?= htmlspecialchars($sub['gambar']) ?>"
                   class="card-img-top"
                   style="object-fit:cover; height:220px;"
                   alt="<?= htmlspecialchars($sub['judul']) ?>">
              <div class="card-body text-center">
                <h5 class="card-title"><?= htmlspecialchars($sub['judul']) ?></h5>
                <p class="card-text small text-muted"><?= htmlspecialchars($sub['deskripsi']) ?></p>
                <a href="kegiatan.php?slug=<?= $sub['slug'] ?>" class="btn btn-outline-primary btn-sm rounded-pill">
                  Lihat Kegiatan
                </a>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p class="text-center text-muted">Belum ada sub album pada album ini.</p>
      <?php endif; ?>
    </div>
</div>

<!-- =================== Modal Tambah Sub Album ================ -->
<div class="modal fade" id="tambahSubAlbumModal" tabindex="-1" aria-labelledby="tambahSubAlbumModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="formSubAlbum" enctype="multipart/form-data" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Sub Album</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="parent_id" value="<?= $id_album ?>">
          <div class="mb-3">
            <label class="form-label">Judul Sub Album</label>
            <input type="text" name="judul" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Gambar Sampul</label>
            <input type="file" name="gambar" accept="image/*" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Tambah</button>
        </div>
      </form>
    </div>
</div>

<!-- ================== Script ================ -->
<script src="js/main.js?<?= time() ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Tambah sub album ajax
document.getElementById("formSubAlbum").addEventListener("submit", function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    formData.append('ajax_submit', '1');
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';

    fetch(window.location.href, {
      method: "POST",
      body: formData
    })
    .then(res => {
        if (!res.ok) {
            throw new Error('Network response was not ok');
        }
        return res.json();
    })
    .then(data => {
      submitBtn.disabled = false;
      submitBtn.innerHTML = originalText;
      
      if (data.success) {
        const modalElement = document.getElementById('tambahSubAlbumModal');
        const modal = bootstrap.Modal.getInstance(modalElement);
        modal.hide();

        const emptyMsg = document.querySelector('#subalbumContainer .text-center.text-muted');
        if (emptyMsg) emptyMsg.remove();

        const container = document.getElementById("subalbumContainer");
        const card = document.createElement("div");
        card.className = "col-md-4 mb-4";
        card.setAttribute('data-id', data.id);
        card.innerHTML = `
          <div class="card h-100 shadow-sm border-0 position-relative">
            <div class="card-actions">
              <button class="btn-delete" onclick="hapusSubAlbum(${data.id}, '${data.judul}')">
                <i class="fas fa-trash"></i>
              </button>
            </div>
            <img src="../${data.gambar}" class="card-img-top" style="object-fit:cover; height:220px;" alt="${data.judul}">
            <div class="card-body text-center">
              <h5 class="card-title">${data.judul}</h5>
              <p class="card-text small text-muted">${data.deskripsi}</p>
              <a href="kegiatan.php?slug=${data.slug}" class="btn btn-outline-primary btn-sm rounded-pill">Lihat Kegiatan</a>
            </div>
          </div>`;
        container.prepend(card);

        this.reset();
        alert("Sub album berhasil ditambahkan!");
      } else {
        alert("Gagal: " + data.message);
      }
    })
    .catch(err => {
      submitBtn.disabled = false;
      submitBtn.innerHTML = originalText;
      console.error('Error:', err);
      alert("Terjadi kesalahan saat mengirim data: " + err.message);
    });
});

// Fungsi hapus sub album
function hapusSubAlbum(id, judul) {
    if (!confirm(`Apakah Anda yakin ingin menghapus sub album "${judul}"?\n\nPeringatan: Semua foto dalam sub album ini juga akan terhapus!`)) {
        return;
    }

    const formData = new FormData();
    formData.append('hapus_subalbum', '1');
    formData.append('id', id);

    fetch(window.location.href, {
        method: "POST",
        body: formData
    })
    .then(res => {
        if (!res.ok) {
            throw new Error('Network response was not ok');
        }
        return res.json();
    })
    .then(data => {
        if (data.success) {
            // Hapus card dari DOM dengan animasi
            const card = document.querySelector(`[data-id="${id}"]`);
            if (card) {
                card.style.opacity = '0';
                card.style.transform = 'scale(0.8)';
                card.style.transition = 'all 0.3s ease';
                
                setTimeout(() => {
                    card.remove();
                    
                    // Cek apakah masih ada sub album
                    const container = document.getElementById('subalbumContainer');
                    if (container.children.length === 0) {
                        container.innerHTML = '<p class="text-center text-muted">Belum ada sub album pada album ini.</p>';
                    }
                }, 300);
            }
            
            alert("Sub album berhasil dihapus!");
        } else {
            alert("Gagal menghapus: " + data.message);
        }
    })
    .catch(err => {
        console.error('Error:', err);
        alert("Terjadi kesalahan saat menghapus data: " + err.message);
    });
}
</script>
</body>
</html>