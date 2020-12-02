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
    
                            <a class="navbar-item" href="{{ route('platforms') }}"">
                                Platforms
                            </a>
                        </div>
                    </div>

                    <div class="navbar-end">
                        <div class="navbar-item">
                            <div class="buttons">
                                @if(Auth::user())
                                    Hello, {{ Auth::user()->name }}
                                @else
                                <a class="button is-primary">
                                    <strong>Sign up</strong>
                                </a>

                                <a class="button is-light" href="{{ route('login') }}">
                                    Log in
                                </a>
                                @endif
                            </div>
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
