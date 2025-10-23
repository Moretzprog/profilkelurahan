<?php
// koneksi database
include '../koneksi.php'; // pastikan file koneksi.php ada dan benar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ambil data dari form
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $saran = mysqli_real_escape_string($koneksi, $_POST['saran']);

    // simpan ke database
    $query = "INSERT INTO t_saran (nama, email, saran) VALUES ('$nama', '$email', '$saran')";
    if (mysqli_query($koneksi, $query)) {
        echo "Saran berhasil dikirim!";
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($koneksi);
    }
} else {
    echo "Akses ditolak!";
}
?>
