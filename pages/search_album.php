<?php
include '../koneksi.php';
header('Content-Type: application/json');

$keyword = isset($_GET['q']) ? mysqli_real_escape_string($koneksi, $_GET['q']) : '';

$sql = "SELECT * FROM t_galeri WHERE judul LIKE '%$keyword%' OR deskripsi LIKE '%$keyword%' ORDER BY id DESC";
$result = mysqli_query($koneksi, $sql);

$albums = [];
while ($row = mysqli_fetch_assoc($result)) {
    $albums[] = $row;
}

echo json_encode(["status" => "success", "albums" => $albums]);
?>
