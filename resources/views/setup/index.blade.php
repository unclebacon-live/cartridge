@extends('layouts.app', ['hide_navigation' => true])

@section('content')

<div class="container container-small pt-6">
    <div class="card">
        <div class="card-header page-header">
            <h1>Setup</h1>
        </div>

        <div class="card-content content">
            <h2>{{ __('Admin User') }}</h2>
            <form method="POST" action="{{ route('setup') }}">
                @csrf

                <div class="field">
                    <label class="label" for="name">Name</label>
                    <div class="control">
                        <input id="name" type="text" class="input @error('name') is-danger @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <p class="help is-danger" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="email">Email</label>
                    <div class="control">
                        <input id="email" type="email" class="input @error('email') is-danger @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <p class="help is-danger" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="password">Password</label>
                    <div class="control">
                        <input id="password" type="password" class="input @error('password') is-danger @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <p class="help is-danger" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="field">
                    <label class="label" type="password" for="password-confirm">{{ __('Confirm Password') }}</label>
                    <div class="control">
                        <input id="password-confirm" type="password" class="input @error('password') is-danger @enderror" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <hr>

                <div class="field">
                    <p class="control">
                        <button type="submit" class="button is-primary">
                            {{ __('Submit') }}
                        </button>
                    </p>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
