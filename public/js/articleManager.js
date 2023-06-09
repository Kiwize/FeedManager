var currentPage = "/api/articles?results=20&page=1";

function getArticleList(_url = currentPage) {
  $.ajax({
    url: _url,
    type: "GET",
    error: function (xhr) {
      showErrorNotification(xhr.responseJson);
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

      const articles = Object.values(data.data);
      var shownFeeds = [];

      articles.forEach((element) => {
        if (!shownFeeds.includes(element.author_detail.id)) {
          shownFeeds.push(element.author_detail.id);
        }
      });

      sendAPIFeedsPOSTRequest(shownFeeds, articles);
      $(".pageCounter").html(data.current_page + " / " + data.last_page);
    },
  });
}

function sendAPIFeedsPOSTRequest(shownFeeds, articles) {
  $.ajax({
    url: "/api/feeds",
    type: "POST",
    data: {
      feed_id_array: shownFeeds,
    },
    error: function (xhr) {
      showErrorNotification(xhr.responseJson);
    },
    success: function (_data) {
      var articleHTML = "";
      articles.forEach((element) => {
        _data.forEach((feed) => {
          if (feed.id === element.author_detail.id) {
            articleHTML +=
              "<tr>" +
              "<th>" +
              "<img class='img-thumbnail' src='"+feed.author_logo + "'>" +
              "</th>" +
              "<td>" +
              element.title +
              "</td>" +
              "<td>" +
              element.author_detail.published +
              "</td>" +
              "</tr>";
          }
        });
      });
      $("#article_tab").html(articleHTML);
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
