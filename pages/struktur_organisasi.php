<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../koneksi.php';
header('Content-Type: application/json');

$targetDir = "../uploads/struktur"; // folder upload
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file'])) {
        $fileName = time() . "_" . basename($_FILES['file']['name']);
        $targetFile = rtrim($targetDir, '/') . '/' . $fileName;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            $path = 'uploads/struktur/' . $fileName;

            $query = "UPDATE profil_kelurahan SET struktur_gambar = '$path' WHERE id = 1";
            mysqli_query($koneksi, $query);

            echo json_encode([
                "status" => "success",
                "path" => $path
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Gagal memindahkan file."
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Tidak ada file dikirim."
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method."
    ]);
}
?>
