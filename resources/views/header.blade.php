    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="/js/notification.js"></script>
    <script src="{{ asset('js/loading.js') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="/css/loading.css" rel="stylesheet">
    <link href="/css/notification.css" rel="stylesheet">

    <header class=" bg-primary pb-2 pt-2">
        <nav class=" round flex-sm-row d-flex justify-content-center">
            <ul class="p-0 mx-2"><a class="lead text-white" href="/">Accueil</a></ul>
            <ul class="p-0 mx-2"><a class="lead text-white" href="/manager">Sources</a></ul>
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
    </body>