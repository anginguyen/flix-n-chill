@extends('layouts/main')

@section('title', 'Results for ' . $query . ' | Flix&Chill')

@section('content')
<form action="{{ route('search') }}" method="GET" class="mb-4">
    <div class="form-group mb-3">
        <input type="text" name="query" placeholder="Search by name" class="form-control" value="{{ old('query', $query) }}">

        @error('query')
            <small class="text text-danger">{{ $message }}</small>
        @enderror 
    </div>
    
    <div class="mb-2 d-flex justify-content-between align-items-center">
        <div class="form-group d-flex" style="gap: 25px;">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="type" id="movie" value="movie" {{ old('type', $type) === "movie" ? "checked" : ""}}>
                <label class="form-check-label" for="movie">Movie</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="type" id="tv" value="tv" {{ old('type', $type) === "tv" ? "checked" : ""}}>
                <label class="form-check-label" for="tv">TV Show</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="type" id="anime" value="anime" {{ old('type', $type) === "anime" ? "checked" : ""}}>
                <label class="form-check-label" for="anime">Anime</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>

<h2 class="mb-3">Results for {{ $query }}</h2>

<div class="row row-cols-1 row-cols-md-5 g-4">
    @foreach ($response as $item)
        <div class="col">
            <a href="{{ route('show', ['type' => $type, 'id' => $item->ids->simkl_id]) }}" style="text-decoration: none;">
                <div class="card h-100">
                    <img src="https://wsrv.nl/?url=https://simkl.in/posters/{{ $item->poster }}_c.jpg" class="card-img-top" alt="{{ $item->title }} Poster">
                    
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->title }}</h5>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>
@endsection