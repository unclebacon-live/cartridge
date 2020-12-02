@extends('layouts.app')

@section('content')
    <header class="page-header">
        <h1>{{ $platform->name }}</h1>
    </header>

    <div class="container is-fluid">
        @include('games.list', $games)
    </div>
@endsection