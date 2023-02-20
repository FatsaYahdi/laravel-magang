@extends('layouts.app')
@section('content')
<div class="container text-center ">
    @if (Auth::user())
        @if(Auth::user()->pp)
            <img src="{{ asset('/storage/images/'.Auth::user()->pp ) }}" class="rounded-circle float-left m-4 shadow-sm mb-4 img-fluid" style="width: 200px; ">
        @else
            <img src="{{ asset('/images/null.jfif') }}" class="rounded-circle float-left">
        @endif
            <div class="pt-5 text-center">
                <h3>{{ Auth::user()->name }}</h3>
                <h5>{{ Auth::user()->email }}</h5>
                <small><strong>{{ Auth::user()->role }}</strong></small>
            </div>
    @else
        <h2>Please <a href="/login">Login</a> or <a href="/register">Register</a></h2>
    @endif
</div>
@endsection
