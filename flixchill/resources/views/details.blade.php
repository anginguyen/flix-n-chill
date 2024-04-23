@extends('layouts/main')

@section('title', $response->title . ' | Flix&Chill')

@section('content')
<div class="d-flex justify-content-between align-items-center">
    <h1>{{ $response->title }}</h1>

    @if (Auth::user())
        <form action="{{ route('show.favorite') }}" method="POST">
            @csrf

            <input type="hidden" name="id" value="{{ $id }}">
            <input type="hidden" name="title" value="{{ $response->title }}">
            <input type="hidden" name="type" value="{{ $type }}">
            <input type="hidden" name="poster" value="{{ $response->poster }}">
            <input type="checkbox" name="favorite" class="invisible" {{ $isFavorite ? "checked" : ""}} >

            @if ($isFavorite)
                <button type="submit" class="btn btn-warning">Favorited</button>
            @else
                <button type="submit" class="btn btn-outline-warning">Add to Favorites</button>
            @endif
        </form>
    @endif
</div>

<div class="row mt-4">
    <div class="col-4">
        <img src="https://wsrv.nl/?url=https://simkl.in/posters/{{ $response->poster }}_m.jpg" alt="{{ $response->title }} Poster">

        @if ($response->genres)
            <ul class="list-inline mt-3">
                @foreach ($response->genres as $genre)
                    <li class="list-inline-item btn btn-outline-secondary mb-2"><small>{{ $genre }}</small></li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="col-8">
        <h3>Overview</h3>
        <p>{{ $response->overview }}</p>

        <div class="mt-5">
            <h3>Reviews</h3>

            @if (Auth::user())
                <form action="{{ route('show.post') }}" method="POST">
                    @csrf 

                    <input type="hidden" name="id" value="{{ $id }}">
                    <input type="hidden" name="title" value="{{ $response->title }}">
                    <input type="hidden" name="type" value="{{ $type }}">
                    <input type="hidden" name="poster" value="{{ $response->poster }}">

                    <textarea class="form-control" rows="3" placeholder="Write your review here" name="review"></textarea>

                    <div class="form-group d-flex justify-content-between">
                        <small class="text text-danger">
                            @error('review'){{ $message }}@enderror
                        </small>

                        <button type="submit" class="btn btn-primary mt-3">Post</button>
                    </div>
                </form>
            @else
                <textarea class="form-control" id="disabledTextInput" rows="3" placeholder="You must be logged in to write a review" readonly></textarea>
            @endif

            <div class="mt-4">
                @if (count($reviews) > 0)
                    @foreach ($reviews as $review)
                        @if (isset($review_id) && $review_id == $review->id)
                            <div class="card bg-light mb-3">
                                <div class="card-header"><strong>{{ $review->user->name }}</strong></div>

                                <form action="{{ route('show.update', ['type' => $type, 'id' => $id, 'review_id' => $review->id]) }}" method="POST">
                                    @csrf
                                    <div class="card-body">
                                        <textarea class="form-control" rows="3" placeholder="Write your review here" name="review-edit">{{ old('review-edit', $review->description) }}</textarea>

                                        @error('review-edit')
                                            <small class="text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="card-footer d-flex justify-content-between align-items-center">
                                        <div class="d-flex">
                                            <button type="submit" class="btn btn-outline-primary btn-sm">Save</button>

                                            <form action="{{ route('profile.delete', ['id' => $review->id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger btn-sm mx-1">Delete</button>
                                            </form>
                                        </div>

                                        <small class="text-muted">Posted {{ date_format($review->created_at, 'D, M j') }} at {{ date_format($review->created_at, 'g:i A') }}</small>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="card bg-light mb-3">
                                <div class="card-header"><strong>{{ $review->user->name }}</strong></div>

                                <div class="card-body">
                                    <p class="card-text">{{ $review->description }}</p>
                                </div>

                                @if (Auth::user() && $review->user_id == Auth::user()->id)
                                    <div class="card-footer d-flex justify-content-between align-items-center">
                                        <div class="d-flex">
                                            <form action="{{ route('show.edit', ['type' => $type, 'id' => $id, 'review_id' => $review->id]) }}" method="GET">
                                                <button type="submit" class="btn btn-outline-dark btn-sm">Edit</button>
                                            </form>
                                            <form action="{{ route('profile.delete', ['id' => $review->id]) }}" method="POST" class="px-1">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                            </form>
                                        </div>

                                        <small class="text-muted">Posted {{ date_format($review->created_at, 'D, M j') }} at {{ date_format($review->created_at, 'g:i A') }}</small>
                                    </div>
                                @else
                                    <div class="card-footer d-flex justify-content-end">
                                        <small class="text-muted">Posted {{ date_format($review->created_at, 'D, M j') }} at {{ date_format($review->created_at, 'g:i A') }}</small>
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endforeach
                @else
                    <h5>No reviews yet.</h5>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection