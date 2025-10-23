<?php 
include '../koneksi.php';

$result = mysqli_query($koneksi,'SELECT * FROM t_contact LIMIT 1');
if ($row = mysqli_fetch_array($result)) {
    echo json_encode($row);
} else {
    echo json_encode(['alamat' => '', 'telepon' => '', 'email' => '']);
}