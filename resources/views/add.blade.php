<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('css/add.css?v=').time()?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('css/navigation.css?v=').time()?>">
    <title>Ajouter une source</title>
</head>
    <body>
        <header>
            <h1>Ajouter une nouvelle source</h1>
            <nav>
                <ul><a href="/">Accueil</a></ul>
                <ul><a href="/search">Recherche</a></ul>
                <ul><a href="/manager">Sources</a></ul>
            </nav>
        </header>
        <section>
            <form method="POST" action="/feed-add-request">
                @csrf
                <div>
                    <label for="name">Nom de la source (Entre 6 et 20 caractères)</label>
                    <input type="text" id="name" name="name" required pattern="[a-zA-Z0-9]+" minlength="6" maxlength="20">
                </div>
                <div>
                    <label for="link">URL de la source</label>
                    <input type="text" id="link" name="link" required>
                </div>
                <input id="submit_button" type="submit" value="Ajouter">
            </form>
        </section>
    </body>
</html>