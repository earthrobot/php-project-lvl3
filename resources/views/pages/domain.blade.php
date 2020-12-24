<!DOCTYPE html>
<html>
    <body>      
        @if (!empty($domain)) 
            {{ $domain->name }}
        @endif
    </body>    
</html>
