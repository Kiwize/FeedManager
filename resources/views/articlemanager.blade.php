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
    <script type="text/javascript" src="<?php echo "js/articleManager.js" ?>"></script>
    @include('header')
    <div id="content">
        <h2 class="h2 text-center mt-3 mb-2">Les dernières parutions</h2>
        @if(count($articles) === 0)
        <h3 class="h3 text-center mt-3">Il n'y a rien à afficher pour le moment...</h3>
        @else

        <div class="input-group d-flex flex-row justify-content-lg-around mt-lg-4">
            <div class="form-inline">
                <form action="{{ route('home') }}" method="get" class="d-flex flex-row justify-content-center">
                    <label class=" form-label lead">Langue : </label>
                    <div class=" form-group mx-2">
                        <select class=" selector form-control" name="localeFilter" onchange="this.form.submit()">
                            <option value=" ">Tout</option>
                            @foreach($locales as $locale)
                            <option value="{{$locale->locale}}" {{ request('localeFilter') == $locale->locale ? 'selected' : '' }}>{{ strtoupper($locale->locale)}}</option>
                            @endforeach
                        </select>
                    </div>

                    <label class=" form-label lead">Résultats par page : </label>
                    <div class=" form-group mx-2">
                        <select class=" selector form-control" name="resultsPerPage" onchange="this.form.submit()">
                            @foreach($per_page as $val)
                            <option value="{{$val}}" {{request('resultsPerPage') == $val ? 'selected' : '' }}>{{$val}}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        </div>
        <section class="page container d-flex flex-column justify-content-center">
            <div id="article_list" class=" container">
                <table class=" table table-responsive-md table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Titre</th>
                            <th scope="col">Langue</th>
                            <th scope="col">Date de publication</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody id="article_tab">
                        @foreach($articles as $article)
                        <tr>
                            <th scope="row">{{ $article->id }}</th>
                            <td class="lead">{{ $article->title}}</td>
                            <td class="lead text-center">{{ strtoupper($article->locale) }}</td>
                            <td>{{ $article->pubdate}}</td>
                            <td><img class="author_logo" src="{{$icon_feeds[$article->feed_id]}}"></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
        <div class="text-center d-flex flex-row justify-content-center mx-auto mt-3 mb-4 pb-2 pt-2 w-50">
            {!! $articles->appends(request()->query())->links() !!}
        </div>
        @endif
    </div>
</body>

</html>
