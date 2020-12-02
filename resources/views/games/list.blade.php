<div class="game-list">
    @foreach($games as $game)
        <a href="{{ route('game', $game->slug) }}" class="game-cover-container" title="{{ $game->name }}">
            <img src="{{ $game->getCoverUrl() }}" class="game-cover" alt="Cover image for {{ $game->name }}" />
        </a>
    @endforeach
</div>