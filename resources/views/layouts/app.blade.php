<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', env('APP_NAME'))</title>

        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@700&family=Comfortaa:wght@700&display=swap" rel="stylesheet"> 

        <script src="{{ asset('js/app.js') }}" defer></script>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>

    <body>
        <div id="app">
            <nav class="navbar is-dark" id="menu" role="navigation" aria-label="main navigation">
                <div class="container is-fluid">
                    <div class="navbar-brand">
                        <a class="navbar-item" href="/">
                            <img src="{{ asset('images/logo.png') }}" alt="{{ env('APP_NAME') }}" />
                        </a>
    
                        <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                            <span aria-hidden="true"></span>
                            <span aria-hidden="true"></span>
                            <span aria-hidden="true"></span>
                        </a>
                    </div>
    
                    <div id="navbarBasicExample" class="navbar-menu">
                        <div class="navbar-start">
                            @if(config('cartridge.allow_guests') || Auth::check())
                                <a class="navbar-item" href="{{ route('games') }}">
                                    Games
                                </a>
        
                                <a class="navbar-item" href="{{ route('platforms') }}">
                                    Platforms
                                </a>
                            @endif
                        </div>

                        <div class="navbar-end">
                            @guest
                                <div class="navbar-item">
                                    <div class="buttons">
                                        @if (Route::has('login'))
                                            <a class="button is-light" href="{{ route('login') }}">
                                                {{ __('Login') }}
                                            </a>
                                        @endif
                                
                                        @if (Route::has('register'))
                                            <a class="button is-primary" href="{{ route('register') }}">
                                                <strong>{{ __('Register') }}</strong>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="navbar-item has-dropdown is-hoverable">
                                    <a class="navbar-link">
                                        <span class="icon icon-small">
                                            <x-icon name="user"></x-icon> 
                                        </span>

                                        <span>
                                            {{ Auth::user()->name }}
                                        </span>
                                    </a>

                                    <div class="navbar-dropdown">
                                        <a class="navbar-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                            <span class="icon icon-small">
                                                <x-icon name="log-out"></x-icon> 
                                            </span>

                                            <span>
                                                {{ __('Logout') }}
                                            </span>
                                        </a>
        
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            @endguest
                        </div>
                    </div>
                </div>
            </nav>

            <main>
                @yield('content')
            </main>
        </div>
    </body>
</html>
