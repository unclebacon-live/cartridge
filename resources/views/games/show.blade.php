@extends('layouts.app')

@section('content')
    <div class="game-background-container">
        <div class="game-background" style="background-image:url({{ $game->getBackgroundUrl() }})"></div>
    </div>

    <div class="container game-info-container">
        <header class="game-header columns">
            <div class="column is-one-quarter">
                <img src="{{ $game->getCoverUrl() }}" class="game-cover" alt="Cover image for {{ $game->name }}" />

                @foreach($game->files as $file)
                    <a href="{{ $file->getDownloadUrl() }}" class="button is-primary is-fullwidth is-medium download-button">
                        <span class="icon is-small"><x-icon name="download"></x-icon></span>
                        <span>Download  ({{ $file->platform->metadata->abbreviation }})</span>
                    </a>
                @endforeach
            </div>
    
            <div class="column game-info">
                <h1 class="game-name">{{ $game->name }}</h1>

                <div class="content">
                    @if(isset($game->metadata->summary))
                        <p>{{ $game->metadata->summary }}</p>
                    @endif
                </div>
            </div>
        </header>
    </div>
@endsection