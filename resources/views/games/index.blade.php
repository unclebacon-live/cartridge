@extends('layouts.app')

@section('content')
    @foreach($games as $game)
        <img src="{{ $game->getCoverUrl() }}" class="game-cover" alt="Cover image for {{ $game->name }}" />
    @endforeach
@endsection