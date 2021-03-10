@extends('layouts.app')

@section('content')
    @if(!count($games))
        <x-not-found>No games found.</x-not-found>
    @else
        <div class="container is-fluid">
            @include('games.list')
        </div>
    @endif
@endsection
