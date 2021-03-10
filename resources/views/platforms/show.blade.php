@extends('layouts.app')

@section('content')
    @if(!$platform)
        <x-not-found>Platform not found.</x-not-found>
    @else
        <header class="page-header">
            <h1>{{ $platform->name }}</h1>
        </header>

        <div class="container is-fluid">
            @include('games.list', $platform->games)
        </div>
    @endif
@endsection
