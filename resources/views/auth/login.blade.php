@extends('layouts.app')

@section('title', 'Log in')

@section('content')
<div class="card narrow">
    <h1>Log in</h1>

    @if (session('status'))
        <p class="notice">{{ session('status') }}</p>
    @endif

    @if ($errors->any())
        <p class="error">{{ $errors->first() }}</p>
    @endif

    <form method="POST" action="{{ url('/login') }}">
        @csrf
        <label>Username
            <input name="username" value="{{ old('username') }}" required autofocus>
        </label>
        <label>Password
            <input name="password" type="password" required>
        </label>
        <button type="submit">Log in</button>
    </form>
</div>
@endsection