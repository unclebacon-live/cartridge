@extends('layouts.main')

@section('content')
    <div class="feature-image-container">
        <div class="feature-image" style="background-image:url({{ $game->background_path }})"></div>
        <div class="feature-image-overlay"></div>
    </div>

    <div class="container game-page">
        <div class="columns">
            <div class="column is-one-fifth">
                <img src="{{ $game->cover_path }}" class="game-cover" alt="Cover image for {{ $game->name }}" />

                <div class="buttons">
                    @foreach($game->files as $file)
                        @if($file->path_exists)
                            <a href="{{ $file->download_url }}" class="button is-primary is-fullwidth is-medium download-button">
                                <icon type="download"></icon>
                                <span>Download  ({{ $file->platform->metadata->abbreviation }})</span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="column">
                <div class="columns">
                    <div class="column px-6">
                        <h1 class="game-name">{{ $game->name }}</h1>
                        <div class="content">
                            <p>{!! $game->description !!}</p>
                        </div>
                    </div>

                    <div class="column is-one-quarter">
                        <div class="buttons">
                            <a href="https://www.igdb.com/games/{{ $game->slug }}" class="button is-primary is-large is-fullwidth" target="new">IGDB</a>
                            @foreach($game->link_list as $link)
                                <a href="{{ $link["url"] }}" class="button is-white is-fullwidth" target="new">{{ $link["category"] }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
