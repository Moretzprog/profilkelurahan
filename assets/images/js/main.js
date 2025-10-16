$(document).ready(function() {
  $("#saveBtn").click(function() {
    const deskripsi = $("#editDescription").val();
    const visi = $("#editVision").val();
    const misi = $("#editMission").val();

    $.ajax({
      url: "../save_content.php",
      type: "POST",
      data: { deskripsi, visi, misi },
      dataType: "json",
      success: function(response) {
        if (response.status === "success") {
          $("#kelurahan-description").html(deskripsi.replace(/\n/g, "<br>"));
          $("#kelurahan-vision").html("<strong>Visi:</strong> " + visi.replace(/\n/g, "<br>"));
          $("#kelurahan-mission").html("<strong>Misi:</strong> " + misi.replace(/\n/g, "<br>"));

          $("#editContentModal").modal("hide");
        } else {
          alert("Gagal menyimpan perubahan: " + response.message);
        }
      },
      error: function() {
        alert("Terjadi kesalahan pada server.");
      }
    });
  });
});
