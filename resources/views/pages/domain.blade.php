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
                            <a class="nav-link active" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="/domains">Domains</a>
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
    

        <div class="container-lg">
        <h1 class="mt-5 mb-3">Site: {{ $domain->name }}</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                    <tr>
                        <td>id</td>
                        <td>{{ $domain->id }}</td>
                    </tr>
                                    <tr>
                        <td>name</td>
                        <td>{{ $domain->name }}</td>
                    </tr>
                                    <tr>
                        <td>created_at</td>
                        <td>{{ $domain->created_at }}</td>
                    </tr>
                                    <tr>
                        <td>updated_at</td>
                        <td>{{ $domain->updated_at }}</td>
                    </tr>
            </table>
        </div>
            <h2 class="mt-5 mb-3">Checks</h2>
            <form method="post" action="/domains/{{ $domain->id }}/checks">
                {{ csrf_field() }}           
                <input type="submit" class="btn btn-primary" value="Run check">
            </form>
            <table class="table table-bordered table-hover text-nowrap">
                <tr>
                    <th>Id</th>
                    <th>Status Code</th>
                    <th>h1</th>
                    <th>Keywords</th>
                    <th>Description</th>
                    <th>Created At</th>
                </tr>
                @if (!empty($domain_checks)) 
                    @foreach ($domain_checks as $domain_check)
                    <tr>
                        <th>{{ $domain_check->id }}</th>
                        <th>{{ $domain_check->status_code }}</th>
                        <th>{{ $domain_check->h1 }}</th>
                        <th>{{ $domain_check->keywords }}</th>
                        <th>{{ $domain_check->description }}</th>
                        <th>{{ $domain_check->created_at }}</th>
                    </tr>
                    @endforeach
                @endif
            </table>
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