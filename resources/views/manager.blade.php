<?php

use App\Models\Feed;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\FeedsController;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Gestionnaire de sources</title>
</head>

<body onload="javascript:loadFeedsFromDB()" class=" nv-background" data-bs-theme="dark">
    <script type="text/javascript" src="<?php echo "js/feedManager.js" ?>"></script>
    @include('header')
    <div class="parent flex-row d-flex justify-content-start fixed bg-">
        <aside id="feed_list_section" class=" col-md-4 ml-2 custom-aside">
            <div id="feed_list" class=" flex-column d-flex">
            </div>
        </aside>
        <section id="feed_view_section" class=" container-fluid">
            <div id="feed_view" class="">
                <!--Default values-->
                <h2 id="feed_name_text" class=" font">Aucune source sélectionnée.</h2>
                <p id="feed_url_text">URL > <a id="feed_url_link" href=""></a></p>
            </div>
        </section>
    </div>
    <div class="fixed-bottom container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="rounded-pill p-2 d-flex flex-row justify-content-center buttons-container">
                    <button id="add_button" class="btn btn-primary" onclick="window.location.replace('/add');">Ajouter</button>
                    <button id="remove_button" class="btn btn-danger" onclick="javascript:deleteFeed();" disabled>Supprimer</button>
                </div>
            </div>
        </div>
    </div>
    <style>
        .custom-aside {
            width: 250px;
        }

        .buttons-container {
            background-color: rgba(20, 20, 20, 80);
            box-shadow: 0px 0px black 10px;
        }

        /* Espacement des boutons */
        .fixed-bottom .btn {
            margin-right: 2px;
            margin-left: 2px;
        }
    </style>
</body>

</html>