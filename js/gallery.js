document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("searchInputGallery");
  const filterMonth = document.getElementById("filterMonth");
  const galleryCols = document.querySelectorAll("#galleryContainer .col-md-4");

  function filterGallery() {
    const searchText = searchInput.value.toLowerCase();
    const selectedMonth = filterMonth.value;
    let matchFound = false;

    galleryCols.forEach((col) => {
      const card = col.querySelector(".gallery-card");
      const title =
        card.querySelector(".card-title")?.innerText.toLowerCase() || "";
      const description =
        card.querySelector(".card-text.small")?.innerText.toLowerCase() || "";
      const date = card.getAttribute("data-date") || "";

      const matchesSearch =
        title.includes(searchText) || description.includes(searchText);

      const matchesMonth = !selectedMonth || date.startsWith(selectedMonth);

      if (matchesSearch && matchesMonth) {
        col.style.display = "block";
        col.style.opacity = "1";
        col.style.transform = "scale(1)";
        col.style.transition = "all 0.3s ease";
        matchFound = true;
      } else {
        col.style.opacity = "0";
        col.style.transform = "scale(0.95)";
        setTimeout(() => (col.style.display = "none"), 200);
      }
    });

    // Pesan "tidak ada hasil"
    const noResultMsg = document.getElementById("noResultMsg");
    if (!matchFound) {
      if (!noResultMsg) {
        const msg = document.createElement("p");
        msg.id = "noResultMsg";
        msg.className = "text-center text-muted mt-3";
        msg.textContent = "Tidak ada kegiatan yang sesuai dengan pencarian.";
        document.getElementById("galleryContainer").after(msg);
      }
    } else {
      if (noResultMsg) noResultMsg.remove();
    }
  }

  searchInput.addEventListener("input", filterGallery);
  filterMonth.addEventListener("change", filterGallery);
});
