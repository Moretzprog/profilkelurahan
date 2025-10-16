//AOS
AOS.init({
  duration: 1000,
  once: true,
});

// Tombol back to top
const backToTop = document.getElementById("backToTop");

// Tampilkan tombol saat scroll > 200px
window.addEventListener("scroll", () => {
  if (
    document.body.scrollTop > 200 ||
    document.documentElement.scrollTop > 200
  ) {
    backToTop.style.display = "flex";
    backToTop.style.alignItems = "center";
    backToTop.style.justifyContent = "center";
  } else {
    backToTop.style.display = "none";
  }
});

// Klik tombol → scroll ke atas
backToTop.addEventListener("click", () => {
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
});

// Edit konten
document.getElementById("saveBtn").addEventListener("click", function () {
  const deskripsi = document.getElementById("editDescription").value;
  const visi = document.getElementById("editVision").value;
  const misi = document.getElementById("editMission").value;

  fetch("pages/update_profil.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    credentials: "include",
    body: `deskripsi=${encodeURIComponent(deskripsi)}&visi=${encodeURIComponent(
      visi
    )}&misi=${encodeURIComponent(misi)}`,
  })
    .then((response) => response.json())
    .then((result) => {
      if (result.status === "success") {
        const modalEl = document.getElementById("editContentModal");
        const modalInstance =
          bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);

        // Tutup modal dengan transisi
        modalInstance.hide();

        // Tunggu animasi selesai, lalu bersihkan manual
        setTimeout(() => {
          // Hapus backdrop jika masih tertinggal
          document
            .querySelectorAll(".modal-backdrop")
            .forEach((el) => el.remove());
          document.body.classList.remove("modal-open");
          document.body.style.overflow = "";
          document.body.style.paddingRight = "";

          // Update konten di halaman
          document.getElementById("kelurahan-description").innerHTML =
            deskripsi.replace(/\n/g, "<br>");
          document.getElementById("kelurahan-vision").innerHTML =
            "<strong>Visi:</strong> " + visi.replace(/\n/g, "<br>");
          document.getElementById("kelurahan-mission").innerHTML =
            "<strong>Misi:</strong> " + misi.replace(/\n/g, "<br>");

          // Notifikasi sukses
          const alertBox = document.createElement("div");
          alertBox.className =
            "alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3 shadow";
          alertBox.style.zIndex = "9999";
          alertBox.innerHTML = `
    <strong>✅ Berhasil!</strong> Konten berhasil diperbarui.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  `;
          document.body.appendChild(alertBox);
          setTimeout(() => alertBox.remove(), 3000);
        }, 500);
      } else {
        alert("❌ Gagal menyimpan: " + result.message);
      }
    })
    .catch((err) => {
      console.error(err);
      alert("Terjadi kesalahan: " + err);
    });
});

// Upload gambar
document
  .getElementById("image-upload-input")
  .addEventListener("change", function () {
    const file = this.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append("file", file);

    fetch("pages/struktur_organisasi.php", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.text()) // ambil teks mentah dulu
      .then((text) => {
        console.log("Response text:", text); // lihat di console
        try {
          const data = JSON.parse(text);
          if (data.status === "success") {
            document.getElementById("organizational-structure-image").src =
              data.path;
            alert("Gambar berhasil diperbarui!");
          } else {
            alert("Gagal: " + data.message);
          }
        } catch (e) {
          console.error("JSON parse error:", e);
          alert("Respon server tidak valid:\n" + text);
        }
      })
      .catch((err) => {
        console.error(err);
        alert("Terjadi kesalahan upload.");
      });
  });

// Tambah album
document.getElementById("albumForm").addEventListener("submit", function (e) {
  e.preventDefault();
  const formData = new FormData(this);

  fetch("pages/tambah_album.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "success") {
        alert(data.message);
        location.reload();
      } else {
        alert("Gagal: " + data.message);
      }
    })
    .catch((err) => alert("Terjadi kesalahan: " + err));
});

// Hapus album
function deleteAlbum(id) {
  if (!confirm("Yakin ingin menghapus album ini?")) return;

  fetch(`pages/hapus_album.php?id=${id}`, {
    method: "GET",
    credentials: "include",
  })
    .then((response) => response.json())
    .then((result) => {
      if (result.status === "success") {
        // Temukan tombol yang diklik
        const button = document.querySelector(
          `button[onclick="deleteAlbum(${id})"]`
        );
        if (button) {
          // Ambil elemen terdekat yang mewakili album (card, col, dsb)
          const albumContainer = button.closest(
            ".col-md-4, .album-card, .card"
          );
          if (albumContainer) {
            albumContainer.style.transition = "opacity 0.4s ease";
            albumContainer.style.opacity = "0";
            setTimeout(() => albumContainer.remove(), 400);
          }
        }

        // Notifikasi kecil (tanpa elemen tambahan di layout)
        const alertBox = document.createElement("div");
        alertBox.className =
          "alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3 shadow";
        alertBox.style.zIndex = "9999";
        alertBox.innerHTML = `
          <strong>✅ Berhasil!</strong> Album berhasil dihapus.
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alertBox);
        setTimeout(() => alertBox.remove(), 2500);
      } else {
        alert("❌ Gagal menghapus album: " + result.message);
      }
    })
    .catch((err) => {
      console.error(err);
      alert("Terjadi kesalahan: " + err);
    });
}

// Edit Album
function editAlbum(id) {
  fetch(`pages/get_album.php?id=${id}`)
    .then((response) => response.json())
    .then((result) => {
      console.log("Response dari server:", result);

      if (result.status === "success") {
        const data = result.album; // 🔥 ubah 'data' menjadi 'album'

        document.getElementById("editAlbumId").value = data.id;
        document.getElementById("editJudul").value = data.judul;
        document.getElementById("editDeskripsi").value = data.deskripsi;

        // Tampilkan gambar lama
        const imgPreview = document.getElementById("preview-gambar-lama");
        imgPreview.src = data.gambar
          ? data.gambar
          : "https://placehold.co/400x300?text=Tidak+Ada+Gambar";

        // Tampilkan modal
        const modal = new bootstrap.Modal(
          document.getElementById("editAlbumModal")
        );
        modal.show();
      } else {
        alert(result.message || "Album tidak ditemukan.");
      }
    })
    .catch((err) => console.error("Error:", err));
}

// Kirim perubahan ke server
document
  .getElementById("editAlbumForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch("pages/update_album.php", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        alert(data.message);
        if (data.status === "success") {
          location.reload();
        }
      });
  });

// Search Album sama Swipper
const searchInput = document.getElementById("gallery-search");
let placeholderText = "Cari Album (misal: Gotong Royong) ...";
let index = 0;
let showCursor = true;

function typeLoop() {
  searchInput.placeholder =
    placeholderText.slice(0, index) + (showCursor ? "|" : " ");
  if (!showCursor) {
    index++;
    if (index > placeholderText.length) index = 0;
  }
  showCursor = !showCursor;
  setTimeout(typeLoop, showCursor ? 180 : 120);
}

typeLoop();

// ===== Inisialisasi Swiper =====
let swiper = new Swiper(".mySwiper", {
  slidesPerView: 3,
  spaceBetween: 20,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  breakpoints: {
    768: { slidesPerView: 2 },
    992: { slidesPerView: 3 },
  },
});

// ===== Fungsi filter dan search =====
const filterButtons = document.querySelectorAll("[data-tag]");
const swiperWrapper = document.querySelector(".swiper-wrapper");

let currentFilter = "semua";
let currentSearch = "";

let notFoundMsg = document.createElement("div");
notFoundMsg.className = "text-center text-muted mt-3";
notFoundMsg.innerText = "Album tidak ditemukan.";
notFoundMsg.style.display = "none";
swiperWrapper.appendChild(notFoundMsg);

// Fungsi update display slide
function updateSlides() {
  let visibleCount = 0;
  document.querySelectorAll(".swiper-slide.album-item").forEach((slide) => {
    const title = slide.querySelector(".card-title").textContent.toLowerCase();
    const tags = slide.getAttribute("data-tags") || "";
    const matchesSearch = title.includes(currentSearch.toLowerCase());
    const matchesFilter =
      currentFilter === "semua" || tags.includes(currentFilter);

    if (matchesSearch && matchesFilter) {
      slide.style.display = "";
      visibleCount++;
    } else {
      slide.style.display = "none";
    }
  });

  notFoundMsg.style.display = visibleCount === 0 ? "block" : "none";

  swiper.update();
}

// Event tombol filter
filterButtons.forEach((button) => {
  button.addEventListener("click", () => {
    currentFilter = button.getAttribute("data-tag");
    filterButtons.forEach((btn) => btn.classList.remove("active"));
    button.classList.add("active");
    updateSlides();
  });
});

// Event search input
searchInput.addEventListener("input", () => {
  currentSearch = searchInput.value.trim();
  updateSlides();
});
