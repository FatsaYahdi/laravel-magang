@extends('layouts.app')
@section('content')
<div class="container text-center">
    @if (Auth::user())
            <img src="{{ asset('/storage/images/'.Auth::user()->pp ) }}" class="text-center shadow-sm mb-4" style="width: 200px; ">
            <h3>Name : {{ Auth::user()->name }}</h3>
            <h3>Email : {{ Auth::user()->email }}</h3>
            <h3>Address : {{ Auth::user()->address }}</h3>
            <h3>Date Of Birth : {{ Auth::user()->birth }}</h3>
            <h3>Gender : {{ Auth::user()->gender }}</h3>
            <h3>Role : {{ Auth::user()->role }}</h3>
            <h3>Created At : {{ Auth::user()->created_at->diffForHumans() }}</h3>
            <h3>Updated At : {{ Auth::user()->updated_at->diffForHumans() }}</h3>
    @else
        <h2>Please <a href="/login">Login</a> or <a href="/register">Register</a></h2>
    @endif
</div>
@endsection
