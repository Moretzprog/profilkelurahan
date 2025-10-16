// Tab Loading Script
document.addEventListener("DOMContentLoaded", function () {
  const tabButtons = document.querySelectorAll("#customTab .nav-link");
  const tabContent = document.getElementById("tab-content-dinamis");
  const sdaContent = `
        <div class="container py-5 text-center">
            <h1 class="map-title" style="color: #FF0000;">Peta Sumber Daya Alam Kelurahan Sarijaya</h1>
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
    `;

  const saprasContent = `
        <div class="container py-5 text-center">
            <h1 class="map-title" style="color: #FF0000;">Peta Sarana Prasarana Kelurahan Sarijaya</h1>
            <p class="map-description">
                Peta ini menampilkan lokasi fasilitas umum dan infrastruktur penting
                di wilayah Kelurahan Sarijaya.
            </p>

            <!-- Peta -->
            <div class="map-container">
                <!-- Iframe Map -->
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15932.231057623476!2d117.0793836!3d-0.4693394!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df67b3fa697ed01%3A0x46bd8e1e44a2ef3d!2sSarijaya%2C%20Kec.%20Sanga-Sanga%2C%20Kabupaten%20Kutai%20Kartanegara%2C%20Kalimantan%20Timur!5e0!3m2!1sid!2sid!4v1720402557581!5m2!1sid!2sid"
                    class="map-frame"
                    allowfullscreen
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                ></iframe>

                <!-- Legend -->
                <div class="legend-box">
                    <h5 class="fw-bold">Legenda Peta:</h5>
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: #dc3545"></div>
                        Kantor Kelurahan
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: #28a745"></div>
                        Sekolah & Pendidikan
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: #007bff"></div>
                        Fasilitas Kesehatan
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: #ffc107"></div>
                        Tempat Ibadah
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: #6f42c1"></div>
                        Fasilitas Olahraga
                    </div>
                </div>
            </div>

            <!-- Deskripsi Sapras -->
            <div class="mt-5">
                <h4 class="fw-bold">Deskripsi Sarana Prasarana</h4>
                <p class="text-muted">
                    Kelurahan Sarijaya dilengkapi dengan berbagai fasilitas pendukung
                    kehidupan masyarakat seperti sekolah, puskesmas, tempat ibadah,
                    dan fasilitas olahraga yang tersebar merata di seluruh wilayah.
                </p>
            </div>

            <!-- Statistik Sapras -->
            <div class="row text-center mt-4">
                <div class="col-md-3">
                    <h5><i class="fas fa-school text-success"></i> 5 unit</h5>
                    <p class="text-muted">Sekolah</p>
                </div>
                <div class="col-md-3">
                    <h5><i class="fas fa-hospital text-danger"></i> 2 unit</h5>
                    <p class="text-muted">Puskesmas</p>
                </div>
                <div class="col-md-3">
                    <h5><i class="fas fa-mosque text-primary"></i> 8 unit</h5>
                    <p class="text-muted">Tempat Ibadah</p>
                </div>
                <div class="col-md-3">
                    <h5><i class="fas fa-running text-warning"></i> 3 unit</h5>
                    <p class="text-muted">Lap. Olahraga</p>
                </div>
            </div>

            <!-- Download dan Maps -->
            <div class="mt-4">
                <a
                    href="assets/peta_sapras_sarijaya.pdf"
                    class="btn btn-outline-secondary me-2"
                    download
                >
                    <i class="fas fa-download me-2"></i>Unduh Peta Sapras (PDF)
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
    `;

  function showLoading() {
    tabContent.innerHTML = `
            <div class="loading-spinner">
                <i class="fas fa-spinner text-primary"></i>
                <p class="text-muted mt-2">Memuat konten...</p>
            </div>
        `;
  }

  function loadContentFromVariable(contentType, button) {
    showLoading();

    // Simulasi delay loading
    setTimeout(() => {
      let content = "";

      if (contentType === "sda") {
        content = sdaContent;
      } else if (contentType === "sapras") {
        content = saprasContent;
      }

      tabContent.innerHTML = content;
      button.dataset.loaded = "true";

      // Smooth animation
      tabContent.style.opacity = "0";
      setTimeout(() => {
        tabContent.style.transition = "opacity 0.3s ease-in-out";
        tabContent.style.opacity = "1";
      }, 100);
    }, 500);
  }

  function tryLoadFromFile(file, button, fallbackType) {
    showLoading();

    fetch(file)
      .then((response) => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.text();
      })
      .then((data) => {
        tabContent.innerHTML = data;
        button.dataset.loaded = "true";

        tabContent.style.opacity = "0";
        setTimeout(() => {
          tabContent.style.transition = "opacity 0.3s ease-in-out";
          tabContent.style.opacity = "1";
        }, 100);
      })
      .catch((err) => {
        console.log("File tidak ditemukan, menggunakan konten internal:", err);
        loadContentFromVariable(fallbackType, button);
      });
  }

  // Event click untuk setiap tab
  tabButtons.forEach((btn) => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();

      // Update active states
      tabButtons.forEach((b) => b.classList.remove("active"));
      this.classList.add("active");

      // Tentukan jenis konten berdasarkan ID
      const tabId = this.id;
      const file = this.getAttribute("data-file");

      if (tabId === "sda-tab") {
        tryLoadFromFile(file, this, "sda");
      } else if (tabId === "sapras-tab") {
        tryLoadFromFile(file, this, "sapras");
      }
    });
  });

  // Load default tab content (SDA) on page load
  if (tabButtons.length > 0) {
    const firstBtn = tabButtons[0];
    loadContentFromVariable("sda", firstBtn);
  }
});
