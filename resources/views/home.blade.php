<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="<?php echo asset('css/home.css?v=').time()?>">
        <link rel="stylesheet" type="text/css" href="<?php echo asset('css/navigation.css?v=').time()?>">
        <title>Home</title>
    </head>
    <body>
        <!--Home page-->
        <header>
            <h1>Outil de gestion de flux d'actualité</h1>
            <nav>
                <ul><a href="/">Accueil</a></ul>
                <ul><a href="/search">Recherche</a></ul>
                <ul><a href="/manager">Sources</a></ul>
            </nav>
        </header>
        <section class="about">
            <h2>Qu'est-ce que c'est ?</h2>
            <p>
                Cet outil a pour but de centraliser l'information depuis plusieurs sources, et de faciliter la recherche d'un sujet en particulier.
            </p>
        </section>
    </body>
</html>