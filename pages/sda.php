<!-- sda.html (khusus untuk di-load via AJAX/fetch) -->
<div class="container py-5 text-center">
  <h1 class="map-title">Peta Sumber Daya Alam Kelurahan Sarijaya</h1>
  <p class="map-description">
    Berikut adalah peta wilayah yang menunjukkan potensi sumber daya alam
    yang dimiliki oleh Kelurahan Sarijaya.
  </p>

  <!-- Peta -->
  <div class="map-container">
    <!-- Iframe Map -->
    <iframe
      src="FixSelasa/index.html"
      class="map-frame"
      allowfullscreen
      loading="lazy"
      referrerpolicy="no-referrer-when-downgrade"
    ></iframe>

    <!-- Legend -->
    <div class="legend-box">
      <h5 class="fw-bold">Legenda Peta:</h5>
      <div class="legend-item">
        <div class="legend-color" style="background-color: #28a745"></div>
        Hutan dan Lahan Hijau
      </div>
      <div class="legend-item">
        <div class="legend-color" style="background-color: #ffc107"></div>
        Perkebunan dan Pertanian
      </div>
      <div class="legend-item">
        <div class="legend-color" style="background-color: #007bff"></div>
        Perairan / Sungai
      </div>
      <div class="legend-item">
        <div class="legend-color" style="background-color: #6f42c1"></div>
        Tambang atau Potensi Mineral
      </div>
      <div class="legend-item">
        <div class="legend-color" style="background-color: #dc3545"></div>
        Daerah Terlindungi / Konservasi
      </div>
    </div>
  </div>

  <!-- Deskripsi SDA -->
  <div class="mt-5">
    <h4 class="fw-bold">Deskripsi Sumber Daya Alam</h4>
    <p class="text-muted">
      Kelurahan Sarijaya memiliki kekayaan sumber daya alam berupa lahan
      pertanian subur, perairan sungai untuk perikanan rakyat, serta area
      hutan lindung yang menjadi bagian konservasi lingkungan. Potensi ini
      mendukung ketahanan pangan dan ekonomi warga.
    </p>
  </div>

  <!-- Statistik SDA -->
  <div class="row text-center mt-4">
    <div class="col-md-4">
      <h5><i class="fas fa-tractor text-success"></i> 140 ha</h5>
      <p class="text-muted">Lahan Pertanian</p>
    </div>
    <div class="col-md-4">
      <h5><i class="fas fa-fish text-primary"></i> 20 ha</h5>
      <p class="text-muted">Perairan & Tambak</p>
    </div>
    <div class="col-md-4">
      <h5><i class="fas fa-tree text-success"></i> 60 ha</h5>
      <p class="text-muted">Hutan Lindung</p>
    </div>
  </div>

  <!-- Download dan Maps -->
  <div class="mt-4">
    <a
      href="assets/peta_sda_sarijaya.pdf"
      class="btn btn-outline-secondary me-2"
      download
    >
      <i class="fas fa-download me-2"></i>Unduh Peta SDA (PDF)
    </a>
    <a
      href="https://www.google.com/maps/place/Sarijaya"
      target="_blank"
      class="btn btn-primary"
    >
      <i class="fas fa-location-arrow me-2"></i>Buka di Google Maps
    </a>
  </div>
</div>
