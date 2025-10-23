<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
include '../koneksi.php';

$id = $_GET['id'] ?? 0;
$query = mysqli_query($koneksi, "SELECT * FROM t_galeri WHERE id='$id'");
if ($row = mysqli_fetch_assoc($query)) {
    echo json_encode(["status" => "success", "album" => $row]);
} else {
    echo json_encode(["status" => "error"]);
}
