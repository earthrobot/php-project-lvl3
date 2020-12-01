<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    </head>

    <body>   
        <div class="container"> 
        @include('flash::message')

        <?php if (!empty($domains)) : ?>

            <ul>
            
                @foreach($domains as $domain)

                    <li>{{ $domain->name }}</li>

                @endforeach
            
            </ul>
        
        <?php endif; ?> 

        </div>

    </body>
    
</html>