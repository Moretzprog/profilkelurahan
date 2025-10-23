<?php
include '../koneksi.php';

$result = mysqli_query($koneksi, "SELECT * FROM t_saran ORDER BY tanggal DESC");

if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        echo '<div class="list-group-item">';
        echo '<h6 class="mb-1">' . htmlspecialchars($row['nama']) . 
             ' <small class="text-muted">' . date('d M Y H:i', strtotime($row['tanggal'])) . '</small></h6>';
        echo '<p class="mb-1">' . htmlspecialchars($row['saran']) . '</p>';
        echo '</div>';
    }
} else {
    echo '<div class="list-group-item">Belum ada saran masuk.</div>';
}
?>
