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
        <h2 class="h2 text-center mt-4">Les dernières parutions</h2>
        <div>
            <div class="text-center d-flex flex-row justify-content-center mx-auto mt-3 mb-4 pb-2 pt-2 w-50">
            {!! $articles->appends(request()->query())->links() !!}
            </div>
            <div>
                <form action="{{ route('articles.fetch') }}" method="get" class="d-flex flex-row justify-content-center">
                    <div class=" form-group mx-2">
                        <label class=" form-label lead">Langue : </label>
                        <select class=" selector" name="localeFilter">
                            <option value=" ">Tout</option>
                            @foreach($locales as $locale)
                            <option value="{{$locale->locale}}" {{ request('localeFilter') == $locale->locale ? 'selected' : '' }}>{{$locale->locale}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mx-2">
                        <label class=" form-label lead">Résultats par page : </label>
                        <select class=" selector" name="resultsPerPage">
                            <option value="20">20</option>
                            <option value="75">75</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                        </select>
                    </div>
                    <div class=" form-group mx-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-search"></i>
                        </button>
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
                            <td><img src="{{$icon_feeds[$article->feed_id]}}"></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
        <div class="text-center d-flex flex-row justify-content-center mx-auto mt-3 mb-4 pb-2 pt-2 w-50">
            {!! $articles->appends(request()->query())->links() !!}
        </div>
    </div>
    <style>
        img {
            width: 60px;
            height: 60px;
            object-fit: cover;
        }
    </style>
</body>

</html>