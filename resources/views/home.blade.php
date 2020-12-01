<!DOCTYPE html>
<html>

    <head>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    </head>

    <body>      
        <div class="container">
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
            <form action="/domains" method="post" class="form-inline">
                <div class="form-group mb-2">
                    {{ csrf_field() }}
                    <input type="text" name="domain[name]" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>   
        </div>
    </body>
    
</html>