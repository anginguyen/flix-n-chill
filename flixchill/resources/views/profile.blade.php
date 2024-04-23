@extends('layouts/main')

@section('title', 'Profile | Flix&Chill')

@section('content')
<h1>{{ Auth::user()->name }}</h1>

<div class="row mt-4">
    <div class="col-6">
        <h4 class="mb-3">Favorites</h4>

        @if (count($favorites) > 0)
            <div class="row row-cols-1 row-cols-md-3">
                @foreach ($favorites as $favorite)
                    <div class="col">
                        <a href="{{ route('show', ['type' => $favorite->media->type, 'id' => $favorite->media->simkl_id]) }}" style="text-decoration: none;">
                            <div class="card h-100">
                                <img src="https://wsrv.nl/?url=https://simkl.in/posters/{{ $favorite->media->poster }}_c.jpg" class="card-img-top" alt="{{ $favorite->media->title }} Poster">
                                
                                <div class="card-body">
                                    <p class="card-title"><strong>{{ $favorite->media->title }}</strong></p>
                                </div>

                                <div class="card-footer d-flex justify-content-between align-items-center">
                                    <form action="{{ route('profile.favorite', ['id' => $favorite->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Remove</button>
                                    </form>
                                    <small class="text-muted">Added {{ date_format($favorite->created_at, 'M j') }}</small>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <p>You have no favorited media.</p>
        @endif
    </div>

    <div class="col-6">
        <h4 class="mb-3">Reviews</h4>

        @if (count($reviews) > 0)
            @foreach ($reviews as $review)
                @if (isset($edit_id) && $edit_id == $review->id)
                    <div class="card mb-3">
                        <div class="card-header">
                            <strong>{{ $review->media->title }}</strong>
                        </div>

                        <form action="{{ route('profile.update', ['id' => $review->id]) }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <textarea class="form-control" rows="3" placeholder="Write your review here" name="review">{{ old('review', $review->description) }}</textarea>

                                @error('review')
                                    <small class="text text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <div>
                                    <button type="submit" class="btn btn-outline-primary btn-sm">Save</button>
                                    <form action="{{ route('profile.delete', ['id' => $review->id]) }}" method="POST" class="px-1">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                    </form>
                                </div>

                                <small class="text-muted">Posted {{ date_format($review->created_at, 'D, M j') }} at {{ date_format($review->created_at, 'g:i A') }}</small>
                            </div>
                        </form>
                    </div>
                @else
                    <a href="{{ route('show', ['type' => $review->media->type, 'id' => $review->media->simkl_id]) }}" style="text-decoration: none;">
                        <div class="card bg-light mb-3">
                            <div class="card-header">
                                <strong>{{ $review->media->title }}</strong>
                            </div>

                            <div class="card-body">
                                <p class="card-text">{{ $review->description }}</p>
                            </div>

                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <div class="d-flex">
                                    <form action="{{ route('profile.edit', ['id' => $review->id]) }}" method="GET">
                                        <button type="submit" class="btn btn-outline-dark btn-sm">Edit</button>
                                    </form>
                                    <form action="{{ route('profile.delete', ['id' => $review->id]) }}" method="POST" class="px-1">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                    </form>
                                </div>

                                <small class="text-muted">Posted {{ date_format($review->created_at, 'D, M j') }} at {{ date_format($review->created_at, 'g:i A') }}</small>
                            </div>
                        </div>
                    </a>
                @endif
            @endforeach
        @else
            <p>You have not posted any reviews.</p>
        @endif
    </div>
</div>
@endsection