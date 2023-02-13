@extends('layouts.app',['title' => 'Show'])

@section('content')
<div class="d-flex container">
    @if ($user->pp == null)
        <img src="{{ asset('/images/null.jfif') }}" class="rounded-circle d-block flex-fill mr-4" style="width: 15%">
    @else
        <img src="{{ asset('/storage/images/'.$user->pp) }}" class="rounded-circle d-block flex-fill">
    @endif
    <div class="flex-fill pt-5">
        <h5>Id : {{ $user->id }}</h3>
        <h5>Username : {{ $user->name }}</h3>
        <h5>Email : {{ $user->email }}</h3>
        <h5>Role : {{ $user->role }}</h3>
    </div>
    <div class="flex-fill pt-5">
        <h5>Address : {{ $user->address }}</h5>
        <h5>Birth : {{ $user->birth }}</h5>
        <h5>Gender : {{ $user->gender }}</h5>
        <h5>Status : {{ $user->status ? 'Active' : 'Inactive' }}</h5>
    </div>
</div>
@endsection