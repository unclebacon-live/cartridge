@extends('layouts.admin')

@section('admin_page')
    <div class="container">
        <div class="content">
            <h1>Hello, {{ Auth::user()->name }}!</h1>
        </div>
    </div>
@endsection