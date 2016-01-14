@extends('layout')

@section('title')
    Log in as Administrator
@stop

@section('content')
    <h2>Say now, "Shibboleth"</h2>
    <form action="{{ URL::route('admin.auth') }}" method="POST" class="pure-form">
        {{ csrf_field() }}

        <!-- Password Form Input -->
        <div class="pure-control-group">
            <label for="password">Password</label>
            <input type="password" name="password" title="password"/>
        </div>

        <div class="pure-controls">
            <input type="submit" value="Log In" class="button" />
        </div>
    </form>
@stop
