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
                            <a class="navbar-item" href="{{ route('games') }}">
                                Games
                            </a>
    
                            <a class="navbar-item" href="{{ route('platforms') }}">
                                Platforms
                            </a>
                        </div>
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
                            <div class="navbar-item">
                                <p>Welcome, {{ Auth::user()->name }}!</p>

                                <div class="buttons">
                                    <a class="button is-light" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
    
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </div>
                </div>
            </nav>

            <main>
                @yield('content')
            </main>
        </div>
    </body>
</html>
