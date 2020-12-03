@extends('layouts.app')

@section('content')
<div class="container">
    <p class="title has-text-white">Welcome, {{ Auth::user()->name }}!</p>
</div>
@endsection
