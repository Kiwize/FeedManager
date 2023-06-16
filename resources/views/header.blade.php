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

    <header class=" bg-primary pb-2 pt-2">
        <figure>
            <img alt="prohacktive_logo" src="">
        </figure>
        <nav class=" round flex-sm-row d-flex justify-content-center">
            <ul class="p-0 mx-2"><a class="lead text-white" href="/">Accueil</a></ul>
            <ul class="p-0 mx-2"><a class="lead text-white" href="/sources">Sources</a></ul>
        </nav>
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
        <div class="popup-content">
            <h3 id="confirm_entitle">Êtes-vous sûr de vouloir continuer ?</h3>
            <div class="btn-group">
                <button type="button" class="btn btn-success" id="validate">Valider</button>
                <button type="button" class="btn btn-secondary" onclick="closeConfirmationPopup()">Annuler</button>
            </div>
        </div>
    </div>
    </body>