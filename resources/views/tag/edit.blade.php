@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header text-bold">{{ __('Create Tag') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('tag.update',$tag->id) }}">
                        @csrf
                        @method('put')
                        <div class="row mb-3">
                            <label for="tag" class="col-md-1 col-form-label text-center">{{ __('Tag') }}</label>

                            <div class="col-md-11">
                                <input id="tag" type="text" class="form-control @error('tag') is-invalid @enderror" name="tag" value="{{ $tag->tag }}" autocomplete="tag">

                                @error('tag')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <input type="hidden" name="created_by" value="{{ Auth::user()->name }}">
                        
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-5">
                                <button type="submit" class="btn btn-secondary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection