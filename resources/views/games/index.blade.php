@extends('layouts.app')

@section('content')
    <div class="game-list">
        @foreach($games as $game)
            <a href="{{ route('game', $game->slug) }}" class="game">
                <figure>
                    <img src="{{ $game->getCoverUrl() }}" class="game-cover" alt="Cover image for {{ $game->name }}" />
                    <figcaption>{{ $game->name }}</figcaption>
                </figure>
            </a>
        @endforeach
    </div>
@endsection