<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Recherche</title>
</head>

<body data-bs-theme="dark">
    <!--Articles retriever and updater scripts-->
    <script type="text/javascript" src="<?php echo "js/articleManager.js" ?>"></script>
    @include('header')
    <div id="content">
        <h2 class="h2 text-center mt-4">Les dernières parutions</h2>
        <!--Page selector on top of the main page-->
        <div class="pageOverview text-center d-flex flex-row justify-content-center mt-3 mb-4 pb-2 pt-2 w-50" id="pageOverviewTop">
            <button id="prev" class="previousPageButton btn btn-primary m-2">Page précédente</button>
            <p class="pageCounter text-center mt-auto mb-auto"></p>
            <button id="next" class="nextPageButton btn btn-primary m-2">Page suivante</button>
        </div>

        <section class="page container d-flex flex-column justify-content-center">
            <div id="article_list" class=" container">
                <table class=" table table-responsive-md table-striped">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Titre</th>
                            <th scope="col">Date de publication</th>
                        </tr>
                    </thead>
                    <tbody id="article_tab">

                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <style>
        .pageOverview {
            background-color: #313539;
            border-radius: 30px;
            margin-left: auto;
            margin-right: auto;
        }

        img {
            width: 60px;
            height: 60px;
            object-fit: cover;
        }
    </style>
</body>

</html>