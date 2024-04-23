@extends('layouts/main')

@section('title', 'Home | Flix&Chill')

@section('content')
@if (Auth::user())
    <h1 class="mb-4">Welcome, {{ Auth::user()->name }}</h1>
@else
    <h1 class="mb-4">Welcome to Flix&Chill</h1>
@endif

<form action="{{ route('search') }}" method="GET">
    <div class="form-group mb-3">
        <input type="text" name="query" placeholder="Search by name" class="form-control" value="{{ old('query') }}">

        @error('query')
            <small class="text text-danger">{{ $message }}</small>
        @enderror 
    </div>
    
    <div class="mb-2 d-flex justify-content-between align-items-center">
        <div class="form-group d-flex" style="gap: 25px;">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="type" id="movie" value="movie" {{ old('type', 'movie') === 'movie' ? "checked" : "" }}>
                <label class="form-check-label" for="movie">Movie</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="type" id="tv" value="tv" {{ old('type', 'movie') === 'tv' ? "checked" : "" }}>
                <label class="form-check-label" for="tv">TV Show</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="type" id="anime" value="anime" {{ old('type', 'movie') === 'anime' ? "checked" : "" }}>
                <label class="form-check-label" for="anime">Anime</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>
@endsection