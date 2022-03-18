<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" type="text/css" href="<?php echo asset('css/search.css?v=') . time() ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('css/navigation.css?v=') . time() ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Recherche</title>
</head>

<body>
    <!--Articles retriever and updater scripts-->
    <script type="text/javascript" src="<?php echo "js/articleManager.js" ?>"></script>

    <header>
        <h1>Rechercher un article</h1>
        <nav>
            <ul><a href="/">Accueil</a></ul>
            <ul><a href="/search">Recherche</a></ul>
            <ul><a href="/manager">Sources</a></ul>
        </nav>
        <div id="search_engine">
            <label id="search_label" for="searchbar">Recherche > </label>
            <input type="text" id="searchbar" name="searchbar">
            <select name="filters" id="searchFiltersDropdown" onchange='getArticleList(document.getElementById("searchbar").value, document.getElementById("searchFiltersDropdown").value, getShowedPage());'>
                <option value="newest" selected>Du plus récent au plus vieux</option>
                <option value="oldest">Du plus vieux au plus récent</option>
                <option value="alphabetTitle">Titre par ordre alphabétique</option>
            </select>

            <p id="dbStats"></p>
            <!--Page selector on top of the main page-->
            <div class="pageOverview" id="pageOverviewTop">
                <button class="previousPageButton"></button>
                <p class="pageCounter"></p>
                <button class="nextPageButton"></button>
            </div>
        </div>
    </header>

    <p id="currentPage"></p>
    <section class="page">
        <div id="article_list"></div>
    </section>


    <!--Page selector at bottom of the main page-->
    <div class="pageOverview" id="pageOverviewBottom">
        <button class="previousPageButton"></button>
        <p class="pageCounter"></p>
        <button class="nextPageButton"></button>
    </div>
</body>

</html>