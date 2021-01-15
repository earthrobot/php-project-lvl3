@extends('layouts.app')

@section('title', 'Domains list')

@section('content')

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
                    <th>{{ $domain->status_code }}</th>
                </tr>
                @endforeach   
            </table>
        </div>
    </div>

@endsection