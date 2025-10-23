<?php
include '../koneksi.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $telepon = mysqli_real_escape_string($koneksi, $_POST['telepon']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);

    $query = "UPDATE t_contact SET alamat='$alamat', telepon='$telepon', email='$email' WHERE id=1";
    if(mysqli_query($koneksi, $query)){
        echo "Informasi kontak berhasil diperbarui!";
    } else {
        echo "Terjadi kesalahan: ".mysqli_error($koneksi);
    }
} else {
    echo "Akses ditolak!";
}
?>
