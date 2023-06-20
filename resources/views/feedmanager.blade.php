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

<body class=" nv-background" data-bs-theme="dark">
    <script type="text/javascript" src="<?php echo "js/feedManager.js" ?>"></script>
    @include('header')
    <h2 class=" h2 text-center mt-3">Gestion des flux</h2>
    <div class="row justify-content-center">
        <div class="rounded-pill p-2 d-flex flex-row justify-content-center buttons-container mt-sm-2">
            <button id="add_button" class="btn btn-primary" onclick="window.location.replace('/feed_add_request');">Ajouter</button>
        </div>
    </div>
    @if(count($feeds) === 0)
    <h3 class="h3 text-center mt-3">Il n'y a rien à afficher pour le moment...</h3>
    @else
    <div class="">
        {{ csrf_field() }}
        <div class="input-group d-flex flex-row justify-content-lg-around mt-lg-4">
            <div class="form-inline">
                <div class="d-flex flex-row justify-content-center">
                    <label for="nameFilter" class="lead form-label">Rechercher : </label>
                    <div class="form-group mx-2">
                        <input type="text" class="form-control" id="nameFilter" name="nameFilter" placeholder="Search feeds" value={{ request('nameFilter') }}>
                    </div>
                    <label for="nameFilter" class="lead form-label">Langue : </label>
                    <div class="form-group mx-2">
                        <select id="localeSelector" class="form-control" name="localeFilter">
                            <option value="">Tout</option>
                            @foreach($locales as $locale)
                            <option value="{{$locale->locale}}" {{ request('localeFilter') == $locale->locale ? 'selected' : '' }}>{{$locale->locale}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button onclick="submitForm();" class="btn btn-primary mx-3"><i class="fa fa-search"></i></button>
                </div>
            </div>
            <script>
                function submitForm() {
                    showLoadingScreen();
                    var _url = "/sources?nameFilter=" + $("#nameFilter").val() + "&localeFilter=" + $("#localeSelector").val();
                    $.ajax({
                        url: _url,
                        type: "GET",
                        error: function(xhr) {
                            showNotification(xhr.responseJSON, "error");
                            hideLoadingScreen();
                        },success: function(_data) {
                            window.location.replace(_url);
                        }
                    })
                }
            </script>
        </div>
    </div>
    <div class="row justify-content-center container mx-auto mt-lg-5">
        <div class="d-flex container justify-content-center">
            {!! $feeds->appends(request()->query())->links() !!}
        </div>
    </div>
    <div class="parent flex-row d-flex justify-content-start fixed container">
        <table class="table table-dark table-striped table-bordered table-sm">
            <thead class="">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Langue</th>
                    <th scope="col">Lien</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <!-- <th scope="col" id="additional_infos_on_errors"></th> -->
                </tr>
            </thead>
            <tbody id="feed_list">
                @foreach($feeds as $feed)
                <tr>
                    <th class="text-center col-auto" scope="row">{{$feed->id}}</th>
                    <td class="lead">{{$feed->name}}</td>
                    <td class="lead">{{$feed->locale}}</td>
                    <td class="lead"><a href="{{$feed->link}}">{{$feed->link}}<a></td>
                    <td class=" text-center col-auto"><img class="author_logo" src="{{$feed->author_logo}}"></td>
                    <td class="text-center col-auto"><button onclick="deleteFeed({{$feed->id}}, '{{$feed->name}}');" class="btn btn-danger">Supprimer</button></td>
                    <!-- <td></td> -->
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</body>

</html>
