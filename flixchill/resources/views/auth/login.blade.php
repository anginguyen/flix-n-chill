@extends('layouts/main')

@section('title', 'Login | Flix&Chill')

@section('content')
<div class="w-50 m-auto mt-5">
    <h1>Log In</h1>

    <form action="{{ route('auth.login') }}" method="POST">
        @csrf

        <div class="form group mt-3">
            <label class="form-label" for="email">Email</label>
            <input type="text" class="form-control" name="email" id="email" value="{{ old('email') }}">

            @error('email')
                <small class="text text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form group mt-3">
            <label class="form-label" for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password">

            @error('password')
                <small class="text text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form group mt-3">
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </div>
    </form>

    <div class="mt-5">
        <small class="text">Don't have an account?</small>
        <div>
            <a href="{{ route('registration') }}" class="btn btn-outline-dark w-100">Register for an account</a>
        </div>
    </div>
</div>
@endsection