@extends('layouts.app')

@section('content')
    <div class="game-background-container">
        <div class="game-background" style="background-image:url({{ $game->background_path }})"></div>
    </div>

    <div class="container game-info-container">
        <header class="game-header columns">
            <div class="column is-one-quarter">
                <img src="{{ $game->cover_path }}" class="game-cover" alt="Cover image for {{ $game->name }}" />

                @foreach($game->files as $file)
                    @if($file->path_exists)
                        <a href="{{ $file->download_url }}" class="button is-primary is-fullwidth is-medium download-button">
                            <icon type="download"></icon>
                            <span>Download  ({{ $file->platform->metadata->abbreviation }})</span>
                        </a>
                    @endif
                @endforeach
            </div>
    
            <div class="column game-info">
                <div class="columns">
                    <div class="column game-info-main">
                        <h1 class="game-name">{{ $game->name }}</h1>

                        <div class="content">
                            @if(isset($game->metadata->summary))
                                <p>{{ $game->metadata->summary }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="column game-info-sidebar is-one-quarter">
                        @foreach($game->link_list as $link)
                            <a href="{{ $link["url"] }}" class="button is-white is-fullwidth" target="new">{{ $link["category"] }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </header>
    </div>
@endsection