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
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="rounded-pill p-2 d-flex flex-row justify-content-center buttons-container">
                <button id="add_button" class="btn btn-primary" onclick="window.location.replace('/add');">Ajouter</button>
            </div>
        </div>
    </div>
    <div class="parent flex-row d-flex justify-content-start fixed bg-">
        <table class="table table-dark table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Lien</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody id="feed_list">

            </tbody>
        </table>
    </div>
</body>

</html>