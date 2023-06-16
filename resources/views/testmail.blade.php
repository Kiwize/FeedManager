<!DOCTYPE html>
<html>
<head>
    <title>Feed add request from {{$feedData['user_uuid']}}</title>
</head>
<body>
    <figure>
        <img id="banner" src="{{ asset("img/logo-prohacktive.png") }}">
    </figure>
    <h1>Demande d'ajout d'un flux d'informations</h1>
    <p>Bonjour,</p>
    <p>L'utilisateur <span>{{$feedData['user_uuid']}}</span> a effectué une demande d'ajout du flux d'informations suivant : </p>
    <p id="feed"><a href="{{$feedData['feed_link']}}">{{$feedData['feed_link']}}</a></p>
</body>
<style>
    h1, p {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        width: 50%;
        margin-left: auto;
        margin-right: auto;
    }

    h1 {
        color: #1c1785;
    }

    img {
        width: 100%;
    }

    figure {
        width: 75%;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 40px;
    }

    #feed {
        font-weight: bold;
    }
</style>
</html>