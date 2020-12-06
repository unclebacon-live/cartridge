@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h2>Recently Added</h2>
    </div>
    <div class="container is-fluid">
        @include('games.list', ['games' => $recent])
    </div>
    <div class="page-header">
        <h2>Most Popular</h2>
    </div>
    <div class="container is-fluid">
        @include('games.list', ['games' => $popular])
    </div>
@endsection
