@extends('layouts.app')

@section('content')
<section class="hero" id="welcome-hero">
    <particles></particles>
    <div class="hero-body">
        <div class="container">
            <img src="{{ asset('images/logo-full.png') }}" alt="Cartridge" />
        </div>
    </div>
</section>
@endsection
