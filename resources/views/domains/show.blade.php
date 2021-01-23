@extends('layouts.app')

@section('title', 'Domain page')

@section('content')

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
        <form method="post" action="{{ route('domains.checks.store', ['id' => $domain->id], false) }}">
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
                    <th>{{ Str::limit($domain_check->h1, 30) }}</th>
                    <th>{{ Str::limit($domain_check->keywords, 30) }}</th>
                    <th>{{ Str::limit($domain_check->description, 30)}}</th>
                    <th>{{ $domain_check->created_at }}</th>
                </tr>
                @endforeach
            @endif
        </table>
    </div>

@endsection