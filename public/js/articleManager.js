var currentPage = "/api/articles?results=20&page=1";

function getArticleList(_url = currentPage) {
  $.ajax({
    url: _url,
    type: "GET",
    error: function (xhr) {
      alert(xhr.responseText);
    },
    success: function (data) {
      if (Object.keys(data.data).length === 0) {
        $("#content").html(
          "<h2 class='h2 text-center mt-4'>Aucun article à afficher...</h2>"
        );
        return;
      }

      if (Object.keys(data.data).length > 0 && data.last_page === 1) {
        $("#prev").remove();
        $("#next").remove();
      } else {
        document.getElementsByClassName("nextPageButton")[0].onclick =
          function () {
            if (data.current_page < data.last_page) {
              currentPage = data.next_page_url + "&results=20";
              getArticleList(currentPage);
            }
          };

        document.getElementsByClassName("previousPageButton")[0].onclick =
          function () {
            if (data.current_page > 1) {
              currentPage = data.prev_page_url + "&results=20";
              getArticleList(currentPage);
            }
          };
      }

      var articleHTML = "";
      var articles = Object.values(data.data);

      articles.forEach((element) => {
        articleHTML += "<p>" + element.title + "</p>";
      });

      $("#article_list").html(articleHTML);
      $(".pageCounter").html(data.current_page + " / " + data.last_page);
    },
  });
}

document.addEventListener("DOMContentLoaded", () => {
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });

  function feedUpdate() {
    $.ajax({
      url: "/api/articles/refresh",
      type: "GET",
    });
  }

  window.setInterval(function () {
    feedUpdate();
  }, 60 * 1000);

  // GLHF
  getArticleList();
});
