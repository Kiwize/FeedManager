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
    <link rel="stylesheet" type="text/css" href="<?php echo asset('css/manager.css?v=') . time() ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('css/navigation.css?v=') . time() ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Gestionnaire de sources</title>
</head>

<body onload="javascript:loadFeedsFromDB()">
    <script type="text/javascript" src="<?php echo "js/feedManager.js" ?>"></script>
    <header>
        <h1>Gestionnaire de sources</h1>
        <nav>
            <ul><a href="/">Accueil</a></ul>
            <ul><a href="/search">Recherche</a></ul>
            <ul><a href="/manager">Sources</a></ul>
        </nav>
    </header>
    <div class="parent">
        <aside id="feed_list_section">
            <div id="feed_list">
                <div id="feed_list"></div>
            </div>
            <div class=buttons>
                <a class="add_button" href="/add">Ajouter</a>
                <button id="remove_button" class="remove_button" onclick="javascript:deleteFeed()" disabled>Supprimer</button>
            </div>
        </aside>
        <section id="feed_view_section">
            <div id="feed_view">
                <!--Default values-->
                <h2 id="feed_name_text">Aucune source sélectionnée.</h2>
                <p id="feed_url_text">URL > <a id="feed_url_link" href=""></a></p>
            </div>
        </section>
    </div>
</body>

</html>