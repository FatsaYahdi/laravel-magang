@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header text-bold">{{ __('Create Category') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('category.store') }}">
                        @csrf
                        @method('put')
                        @honeypot
                        <div class="row mb-3">
                            <label for="category" class="col-md-2 col-form-label text-center">{{ __('Category Name') }}</label>

                            <div class="col-md-10">
                                <input id="category" type="text" class="form-control @error('category') is-invalid @enderror" name="category" value="{{ old('category') }}" autocomplete="category">

                                @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="description" class="col-md-2 col-form-label text-center">{{ __('Description') }}</label>

                            <div class="col-md-10">
                                <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" autocomplete="description">{{ old('description') }}</textarea>

                                @error('description')
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
                                    {{ __('Create') }}
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