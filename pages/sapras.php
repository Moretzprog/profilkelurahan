<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Sarana Prasarana - Kelurahan Sarijaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
        }

        .navbar-brand {
            font-weight: bold;
            color: #dc3545 !important;
        }


        .map-container {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .legend {
            background: #fff;
            border: 1px solid #ccc;
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .legend .item {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .legend .box {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            border-radius: 4px;
        }

        .btn-group-map a {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <i class="fas fa-map-marked-alt me-2"></i>Peta Sarana Prasarana Kelurahan Sarijaya
            </a>
            <a href="index.html#map" class="btn btn-outline-primary btn-sm">&larr; Kembali</a>
        </div>
    </nav>
    <div class="container py-5">
        <h1 class="mb-4 text-center">Peta Sarana Prasarana Kelurahan Sarijaya</h1>

        <!-- Peta Google Maps Embed -->
        <div class="map-container mb-4">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15932.231057623476!2d117.0793836!3d-0.4693394!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df67b3fa697ed01%3A0x46bd8e1e44a2ef3d!2sSarijaya%2C%20Kec.%20Sanga-Sanga%2C%20Kabupaten%20Kutai%20Kartanegara%2C%20Kalimantan%20Timur!5e0!3m2!1sid!2sid!4v1720402557581!5m2!1sid!2sid"
                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <!-- Legenda -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="legend">
                    <h5>Legenda Sarana Prasarana</h5>
                    <div class="item"><div class="box" style="background-color:#0d6efd;"></div> Sekolah</div>
                    <div class="item"><div class="box" style="background-color:#28a745;"></div> Puskesmas</div>
                    <div class="item"><div class="box" style="background-color:#ffc107;"></div> Jalan Utama</div>
                    <div class="item"><div class="box" style="background-color:#dc3545;"></div> Kantor Kelurahan</div>
                </div>
            </div>

            <!-- Info Tambahan -->
            <div class="col-md-6">
                <h5 class="mb-3">Informasi Umum</h5>
                <p>Sarana dan prasarana di Kelurahan Sarijaya mencakup fasilitas pendidikan, kesehatan, dan pelayanan publik. Jalan utama sudah beraspal dan mudah diakses oleh kendaraan roda dua maupun roda empat.</p>
                <div class="btn-group-map">
                    <a href="#" class="btn btn-primary"><i class="fas fa-download"></i> Unduh PDF</a>
                    <a href="https://maps.google.com/?q=Sarijaya" target="_blank" class="btn btn-outline-secondary"><i class="fas fa-map"></i> Lihat di Google Maps</a>
                </div>
            </div>
        </div>

        <!-- Testimoni -->
        <div class="mt-5">
            <h5 class="mb-3">Testimoni Warga</h5>
            <blockquote class="blockquote">
                <p>"Pembangunan sarana prasarana di Sarijaya semakin baik setiap tahunnya. Kami bersyukur atas jalan dan fasilitas yang semakin memadai."</p>
                <footer class="blockquote-footer">Bapak Ahmad, RT 03</footer>
            </blockquote>
        </div>
    </div>
</body>

</html>