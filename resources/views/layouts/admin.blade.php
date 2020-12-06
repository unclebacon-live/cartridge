@extends('layouts.app')

@section('content')
    <div class="columns admin">
        <aside class="sidebar column is-one-fifth">
            <a href="#">Users</a>
            <a href="#">Files</a>
        </aside>

        <div class="column">
            @yield('admin_content')
        </div>
    </div>
@endsection