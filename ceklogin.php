<?php

session_start();


include("koneksi.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $koneksi->real_escape_string($_POST['username']);
    $password = $koneksi->real_escape_string($_POST['password']); 

    // Query mencari user berdasarkan username DAN password
    $sql = "SELECT * FROM tb_admin WHERE username = '$username' AND password = '$password'";
    $result = $koneksi->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        // Login Berhasil!
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['id_admin'] = $row['id_admin'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['nama']     = $row['nama_lengkap'];
      
        // Redirect ke halaman dashboard admin
        header("location: index.php"); 
        exit;

    } else {
        // Username atau Password salah
        $_SESSION['login_error'] = "Username atau Password salah. Silakan coba lagi.";
        header("location: pages/admin_login.php"); // Kembali ke halaman login
        exit;
    }

} else {
    header("location: pages/admin_login.php");
    exit;
}
?>