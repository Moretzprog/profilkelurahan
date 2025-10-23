<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $album_id  = intval($_POST['album_id']); // disesuaikan
    $judul     = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $deskripsi = isset($_POST['deskripsi']) ? mysqli_real_escape_string($koneksi, $_POST['deskripsi']) : '';

    // Cek apakah file diupload
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $namaFile   = $_FILES['gambar']['name'];
        $tmpName    = $_FILES['gambar']['tmp_name'];
        $ukuranFile = $_FILES['gambar']['size'];
        $tipeFile   = $_FILES['gambar']['type'];

        // Validasi tipe file
        $ekstensiValid = ['jpg', 'jpeg', 'png', 'gif'];
        $ekstensi = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

        if (!in_array($ekstensi, $ekstensiValid)) {
            echo "❌ File yang diupload harus berupa gambar (jpg, jpeg, png, gif)";
            exit;
        }

        // Validasi ukuran (maks 5MB)
        if ($ukuranFile > 5 * 1024 * 1024) {
            echo "❌ Ukuran file maksimal 5MB";
            exit;
        }

        // Nama file unik
        $namaBaru = time() . '_' . uniqid() . '.' . $ekstensi;
        $folderTujuan = 'uploads/kegiatan/'; // ✅ arahkan ke folder utama

        // Pastikan folder tujuan ada
        if (!is_dir($folderTujuan)) {
            mkdir($folderTujuan, 0777, true);
        }

        // Pindahkan file
        if (move_uploaded_file($tmpName, $folderTujuan . $namaBaru)) {
            // Simpan path relatif (agar bisa diakses dari kegiatan.php)
            $pathTersimpan = "uploads/kegiatan/$namaBaru";

            // Simpan ke DB
            $query = "INSERT INTO t_foto (album_id, judul, deskripsi, gambar, tanggal_upload)
                      VALUES ('$album_id', '$judul', '$deskripsi', '$pathTersimpan', NOW())";

            if (mysqli_query($koneksi, $query)) {
                // Ambil slug untuk redirect yang benar
                $getSlug = mysqli_query($koneksi, "SELECT slug FROM t_galeri WHERE id = '$album_id'");
                $rowSlug = mysqli_fetch_assoc($getSlug);
                $slug = $rowSlug['slug'];

                // Redirect ke kegiatan.php berdasarkan slug
                header("Location: pages/kegiatan.php?slug=" . urlencode($slug) . "&status=success");
                exit;
            } else {
                echo "❌ Gagal menyimpan ke database: " . mysqli_error($koneksi);
            }
        } else {
            echo "❌ Gagal memindahkan file ke folder tujuan.";
        }
    } else {
        echo "❌ Tidak ada file yang diupload atau terjadi error.";
    }
} else {
    echo "❌ Akses tidak sah.";
}
?>
