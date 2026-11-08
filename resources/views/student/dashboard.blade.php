@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')
<div class="card">
    <h1>Welcome, {{ auth()->user()->name }}</h1>
    <p class="muted">Student dashboard. Your event registrations will appear here.</p>
</div>
@endsection