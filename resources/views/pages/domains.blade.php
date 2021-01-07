<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

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
                <a class="navbar-brand" href="/">Analyzer</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="/domains">Domains</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

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
    

        <main class="flex-grow-1">
            <div class="container-lg">
                <h1 class="mt-5 mb-3">Domains</h1>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-nowrap">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Last check</th>
                            <th>Status Code</th>
                        </tr>
                        @foreach($domains as $domain)
                        <tr>
                            <th>{{ $domain->id }}</th>
                            <th><a href="/domains/{{ $domain->id }}">{{ $domain->name }}</a></th>
                            <th>{{ $domain->updated_at }}</th>
                            <th>{{ $domain->created_at }}</th>
                        </tr>
                        @endforeach   
                    </table>
                </div>
            </div>
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