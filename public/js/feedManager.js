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
        showSuccessNotification("Flux supprimé avec succès !");
      },
      error: function (xhr) {
        hideLoadingScreen();
        showErrorNotification(xhr.responseJSON);
      },
    });
  });
}
