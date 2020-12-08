@extends('layouts.admin')

@section('admin_page')
    <div class="container">
        <div class="content">
            <h1>Hello, {{ Auth::user()->name }}!</h1>
            <div class="buttons">
                <command-button class="is-primary" path="{{ route('cmd_update_library') }}">
                    Update Library
                </command-button>
                <command-button class="is-primary" path="{{ route('cmd_refresh_library') }}">
                    Refresh Library
                </command-button>
            </div>
        </div>
    </div>
@endsection