    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="/js/notification.js"></script>
    <script src="/js/confirm_popup.js"></script>
    <script src="{{ asset('js/loading.js') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="/css/loading.css" rel="stylesheet">
    <link href="/css/notification.css" rel="stylesheet">
    <link href="/css/confirm_popup.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <header class=" pb-2 pt-2 border border-0 border-white rounded-4 mx-auto mt-3">
        <div class="d-flex align-items-center" id="header">
            <div class="my-2 mx-3" id="logo_div">
                <figure class="">
                    <img class="w-100" id="banner" src="{{ asset('img/logo-prohacktive.png') }}">
                </figure>
            </div>
            <nav class="round flex-sm-row d-flex justify-content-center">
                <ul class="p-0 mx-2"><a class="lead text-primary" href="/">Accueil</a></ul>
                <ul class="p-0 mx-2"><a class="lead text-primary" href="/sources">Sources</a></ul>
            </nav>
        </div>
        <div id="notification-container"></div>
    </header>
    <div id="loading-screen">
        <div class="loading-content">
            <div class="spinner-border text-primary" role="status">
            </div>
            <p>Chargement en cours...</p>
        </div>
    </div>
    <div id="confirmation-popup" class="confirmation-popup">
        <div class="popup-content bg-dark rounded-3">
            <h3 id="confirm_entitle" class=" text-center">Êtes-vous sûr de vouloir continuer ?</h3>
            <div class="container">
                <button type="button" class="btn btn-success" id="validate">Valider</button>
                <button type="button" class="btn btn-secondary" onclick="closeConfirmationPopup()">Annuler</button>
            </div>
        </div>
    </div>
    </body>
    <style>
        header {
            width: 90%;
            background-color: #35393d;
            box-shadow: 0px 3px 5px black;
        }

        #logo_div {
            width: 10%;
        }
        .author_logo {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }

        .col-auto {
            width: 1%;
        }
    </style>
