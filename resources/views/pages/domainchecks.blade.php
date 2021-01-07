<!DOCTYPE html>
<html>
    <body>
    @if (!empty($domain_checks)) 
        <table>    
            <th>
                <td>Check id</td>
                <td>Created at</td>
                <td>Updated at</td>
            </th>
            <tr>
                <td>{{ $domain_checks->id }}</td>
                <td>{{ $domain_checks->created_at }}</td>
                <td>{{ $domain_checks->updated_at }}</td>
            </tr> 
        </table>
    @endif
    </body>    
</html>

