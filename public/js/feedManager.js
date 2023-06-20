$.ajaxSetup({
  headers: {
    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
  },
});

function deleteFeed(_id, _name) {
  confirmPopup("Supprimer le flux " + _name + " ?", function () {
    showLoadingScreen();
    closeConfirmationPopup();
    $.ajax({
      url: "/api/feeds/delete",
      type: "DELETE",
      data: {
        feedID: _id,
      },
      success: function () {
        hideLoadingScreen();
        location.reload();
        showNotification("Flux supprimé avec succès !", "success");
      },
      error: function (xhr) {
        hideLoadingScreen();
        showNotification(xhr.responseJSON, "error");
      },
    });
  });
}
