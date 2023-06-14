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
});
