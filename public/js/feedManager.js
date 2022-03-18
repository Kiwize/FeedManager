$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var selectedFeed = null;
var selectedFeedID = null;

function loadFeedsFromDB() {
    $.ajax({
        url: '/feed-getlist-request',
        type: "POST",
        error: function() {
            alert("Cannot list feeds from database !")
        },
        success: function(data) {
            $("#feed_list").html(data.result);
        }
    });
}

function linkOnClick(name, url, id) {
    selectedFeed = name;
    selectedFeedID = id;
    document.getElementById("feed_name_text").textContent = name;
    document.getElementById("feed_url_link").textContent = url;
    document.getElementById("remove_button").disabled = false;
}

function addFeed(_name, _link, _iconLink = null) {
    $.ajax({
        url: '/feed-add-request',
        type: "POST",
        data: {
            name: _name,
            link: _link,
            icon_link: _iconLink
        },
        success: function() {
            console.log("New feed " + _name + " successfully added to the database !");
        }
    })
}

function deleteFeed() {
    if (confirm("Voulez-vous supprimer le flux " + selectedFeed + " ?\nLa suppréssion de ce flux entraînera la suppréssion des articles associés.")) {
        $.ajax({
            url: '/feed-delete-request',
            type: "POST",
            data: {
                feedID: selectedFeedID
            },
            success: function() {
                selectedFeed = null;
                selectedFeedID = null;
                document.getElementById("remove_button").disabled = true;
                location.reload();
            },
            error: function() {
                alert("Echec de la suppréssion du flux : " + selectedFeed);
            }
        });
    }
}