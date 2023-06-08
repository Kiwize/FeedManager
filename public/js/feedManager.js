$.ajaxSetup({
  headers: {
    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
  },
});

var selectedFeed = null;
var selectedFeedID = null;

function loadFeedsFromDB() {
  $.ajax({
    url: "/api/feeds",
    type: "GET",
    error: function (xhr) {
      showErrorNotification(xhr.responseJson);
    },
    success: function (data) {
      var html = "";
      data.result.data.forEach((element) => {
        html +=
          '<tr><th scope="row"> ' +
          element.id +
          "</th>" +
          "<td><p class='lead'>" +
          element.name +
          "<p></td>" +
          "<td><a href='" +
          element.link +
          "' target='_blank'>" +
          element.link +
          "</a></td>" +
          '<td><button class="btn btn-danger" onclick="deleteFeed(' +
          element.id +
          ",'" +
          element.name +
          "');\">Supprimer</button></td>" +
          "</tr>";
      });
      $("#feed_list").html(html);
    },
  });
}

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
        showErrorNotification(xhr.responseJson);
      },
    });
  });
}
