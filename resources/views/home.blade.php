@extends('layouts.app')

@section('content')
    @if(!count($recent) && !count($popular))
        <x-not-found>No games found.</x-not-found>
    @endif

    @if(count($recent))
    <div class="page-header">
        <h2>Recently Added</h2>
    </div>

    <div class="container is-fluid">
        @include('games.list', ['games' => $recent])
    </div>
    @endif

    @if(count($popular))
    <div class="page-header">
        <h2>Most Popular</h2>
    </div>

    <div class="container is-fluid">
        @include('games.list', ['games' => $popular])
    </div>
    @endif
@endsection
