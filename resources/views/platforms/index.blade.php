@extends('layouts.main')

@section('content')
    <header class="page-header">
        <h1>Platforms</h1>
    </header>

    <div class="platform-list">
        @foreach($platforms as $platform)
            <div class="platform">
                <a href="{{ route('platform', $platform->slug) }}" class="button is-primary" title="{{ $platform->name }}">
                    <img src="{{ $platform->logo_path }}" class="platform-logo" alt="Logo for {{ $platform->name }}" />
                </a>
            </div>
        @endforeach
    </div>
@endsection