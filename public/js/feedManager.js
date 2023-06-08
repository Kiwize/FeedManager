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
    error: function () {
      alert("Cannot list feeds from database !");
    },
    success: function (data) {
      console.log(data);
      var html = "";
      data.result.data.forEach((element) => {
        html +=
          "<button class='feedlink btn btn-primary mb-1 mt-1' onclick=\"linkOnClick('" +
          element.name +
          "','" +
          element.link +
          "','" +
          element.id +
          "');\">" +
          element.name +
          "</button>";
      });
      $("#feed_list").html(html);
    },
  });
}

function linkOnClick(name, url, id) {
  selectedFeed = name;
  selectedFeedID = id;
  document.getElementById("feed_name_text").textContent = name;
  document.getElementById("feed_url_link").textContent = url;
  document.getElementById("remove_button").disabled = false;
}

function deleteFeed() {
  if (
    confirm(
      "Voulez-vous supprimer le flux " +
        selectedFeed +
        " ?\nLa suppréssion de ce flux entraînera la suppréssion des articles associés."
    )
  ) {
    $.ajax({
      url: "/api/feeds/delete",
      type: "DELETE",
      data: {
        feedID: selectedFeedID,
      },
      success: function () {
        selectedFeed = null;
        selectedFeedID = null;
        document.getElementById("remove_button").disabled = true;
        location.reload();
      },
      error: function (err) {
        alert(
          "Echec de la suppréssion du flux : " +
            selectedFeed +
            "   " +
            err.responseText
        );
      },
    });
  }
}
