@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/summernote/summernote-bs4.min.css') }}">
@endpush
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header text-bold">{{ __('Create Post') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('post.store') }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        @honeypot
                        {{-- title --}}
                        <div class="row mb-3">
                            <label for="title" class="col-md-2 col-form-label text-center">{{ __('Title') }}</label>

                            <div class="col-md-10">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" autocomplete="title">

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- image --}}
                        <div class="row mb-2">
                            <label for="image" class="col-md-2 col-form-label text-center">{{ __('Thumbnail') }}</label>

                            <div class="col-md-10">
                                <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" autocomplete="image" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">
                                
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <img src="" class="output mt-1" id="output" width="45%">
                            </div>
                        </div>

                        {{-- content --}}
                        <div class="row mb-3">
                            <label for="content" class="col-md-2 col-form-label text-center">{{ __('Description') }}</label>

                            <div class="col-md-10">
                                <textarea name="content" id="content" class="form-control @error('image') is-invalid @enderror"></textarea>

                                @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- pinned --}}
                        <div class="row mb-3">
                            <label for="is_pinned" class="col-md-2 col-form-label text-center">{{ __('Sematkan') }}</label>

                            <div class="col-md-10">
                                <select name="is_pinned" id="is_pinned" class="form-control @error('image') is-invalid @enderror">
                                    <option selected disabled>Pilih 1</option>
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>

                                @error('is_pinned')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- tag --}}
                        <div class="row mb-3">
                            <label for="tags" class="col-md-2 col-form-label text-center">{{ __('Tag') }}</label>

                            <div class="col-md-10">
                                @foreach ($tags as $tag)
                                    <input type="checkbox" name="tags[]" id="tags_{{ $tag->id }}" value="{{ $tag->id }}">
                                    <label for="tags_{{ $tag->id }}">{{ $tag->tag }}</label>
                                @endforeach

                                @error('tags')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Category --}}
                        <div class="row mb-3">
                            <label for="categories" class="col-md-2 col-form-label text-center">{{ __('Category') }}</label>

                            <div class="col-md-10">
                                @foreach ($categories as $category)
                                    <input class="px-2" type="checkbox" name="categories[]" id="categories-{{ $category->id }}" value="{{ $category->id }}">
                                    <label for="categories-{{ $category->id }}">{{ $category->category }}</label>
                                @endforeach

                                @error('categories')
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
@push('scripts')
<script src="{{ asset('vendor/summernote/summernote-bs4.min.js') }}"></script>
<script>
    var loadFile = function(event) {
    var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
        }
    };
    $(document).ready(function() {
        $('#content').summernote();
    })
</script>
@endpush