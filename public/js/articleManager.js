var showedPage = 1;
var _data = null;

function limitArticleDescriptions() {
    $.ajax({
        url: '/article_limitdesc_request',
        type: "GET",
    });
}

function getArticleList(_search = '', _searchFilter = 'newest') {
    $.ajax({
        url: '/article-getlist-request',
        type: "POST",
        data: {
            search: _search,
            searchFilter: _searchFilter,
        },
        error: function() {
            alert("Cannot list articles from database !")
        },
        success: function(data) {
            _data = data.result;
            document.getElementById("currentPage").innerHTML = "Page " + showedPage;
            document.getElementById("dbStats").innerHTML = data.articleCount + " articles enregistrés depuis " + data.feedCount + " sources.";

            if (data.length === 0) {
                $("#article_list").html("");
                return;
            }

            function showPage(isNextPage) {
                if (isNextPage && showedPage < _data.length) {
                    showedPage++;
                } else if (!isNextPage && showedPage > 1) {
                    showedPage--;
                }

                document.getElementById("currentPage").innerHTML = "Page " + showedPage;
                $("#article_list").html(_data[showedPage - 1]);
                $(".pageCounter").html((showedPage) + " / " + _data.length);
            }


            for ($i = 0; $i < 2; $i++) {
                document.getElementsByClassName("nextPageButton")[$i].onclick = function() {
                    showPage(true);
                }

                document.getElementsByClassName("previousPageButton")[$i].onclick = function() {
                    showPage(false);
                }
            }

            $("#article_list").html(_data[showedPage - 1]);
            $(".pageCounter").html((showedPage) + " / " + _data.length);

        }
    })
}

function getShowedPage() {
    return showedPage;
}

document.addEventListener('DOMContentLoaded', () => {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function feedUpdate() {
        $.ajax({
            url: '/article-refresh-request',
            type: "GET",
            success: function() {
                getArticleList(document.getElementById("searchbar").value, document.getElementById("searchFiltersDropdown").value);
            }
        })
    }

    var searchField = document.getElementById("searchbar");

    searchField.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            getArticleList(document.getElementById('searchbar').value, document.getElementById('searchFiltersDropdown').value);
        }
    });

    var select = document.querySelector('#searchFiltersDropdown');
    select.addEventListener('change', function() {
        getArticleList(document.getElementById("searchbar").value, document.getElementById("searchFiltersDropdown").value);
    });

    window.setInterval(function() {
        feedUpdate();
    }, 60 * 1000);

    // GLHF
    getArticleList();
})