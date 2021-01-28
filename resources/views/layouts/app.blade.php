<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel - @yield('title')</title>

        <!-- Scripts -->
        <script src="/js/app.js" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="/css/app.css" rel="stylesheet">
    </head>
    <body class="d-flex flex-column">
        <header>
            <nav class="navbar navbar-expand-md navbar-dark bg-dark">
                <a class="navbar-brand" href="{{ route('home', false) }}">Analyzer</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link {{ HtmlHelper::highlightCurrentLink('home') }}" href="{{ route('home', false) }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ HtmlHelper::highlightCurrentLink('domains.index') }}" href="{{ route('domains.index', false) }}">Domains</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>  

        <main class="flex-grow-1">

            @include('flash::message')
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')

        </main>

        <footer class="border-top py-3 mt-5">
            <div class="container-lg">
                <div class="text-center">
                    created by
                    <a href="https://github.com/earthrobot" target="_blank">earthrobot</a>
                </div>
            </div>
        </footer>
    </body>
</html>