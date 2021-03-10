@extends('layouts.app')

@section('content')
    <div id="admin">
        <aside class="column is-one-fifth sidebar">
            <div class="link-list">
                <a href="{{ route('admin_dashboard') }}"
                    class="{{ Route::currentRouteNamed( 'admin_dashboard' ) ?  'is-active' : '' }}">
                    <icon type="home"></icon>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin_settings') }}"
                    class="{{ Route::currentRouteNamed( 'admin_settings' ) ?  'is-active' : '' }}">
                    <icon type="settings"></icon>
                    <span>Settings</span>
                </a>
                <a href="{{ route('admin_users') }}"
                    class="{{ Route::currentRouteNamed( 'admin_users' ) ?  'is-active' : '' }}">
                    <icon type="users"></icon>
                    <span>Users</span>
                </a>
                <a href="{{ route('admin_logs') }}"
                    class="{{ Route::currentRouteNamed( 'admin_logs' ) ?  'is-active' : '' }}">
                    <icon type="list"></icon>
                    <span>Logs</span>
                </a>
            </div>
        </aside>

        <div class="column admin-page">
            @yield('admin_page')
        </div>
    </div>
@endsection
