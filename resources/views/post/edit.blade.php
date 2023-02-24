@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/summernote/summernote-bs4.min.css') }}">
@endpush
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header text-bold">{{ __('Create Tag') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('post.update',$post->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        @honeypot
                        {{-- title --}}
                        <div class="row mb-3">
                            <label for="title" class="col-md-2 col-form-label text-center">{{ __('Title') }}</label>

                            <div class="col-md-10">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title',$post->title) }}" autocomplete="title">

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- image --}}
                        <div class="row mb-3">
                            <label for="image" class="col-md-2 col-form-label text-center">{{ __('Thumbnail') }}</label>
                            
                            <div class="col-md-10">
                                <input id="image" onchange="loadFile(event)" type="file" class="form-control @error('image') is-invalid @enderror mb-1" name="image" value="{{ old('image',$post->image) }}" autocomplete="image" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">
                                
                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <img src="{{ asset('/storage/images/posts/'.$post->image) }}" class="output mt-1" id="output" width="45%">
                            </div>
                        </div>

                        {{-- content --}}
                        <div class="row mb-3">
                            <label for="content" class="col-md-2 col-form-label text-center">{{ __('Description') }}</label>

                            <div class="col-md-10">
                                <textarea name="content" id="summernote" class="form-control @error('image') is-invalid @enderror">{{ old('content',$post->content) }}</textarea>

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

                        {{-- Tag --}}
                        <div class="row mb-3">
                            <label for="tags" class="col-md-2 col-form-label text-center">{{ __('Tag') }}</label>

                            <div class="col-md-10">
                                @foreach ($tags as $tag)
                                    <input type="checkbox" name="tags[]" id="tags_{{ $tag->id }}" value="{{ $tag->id }}" {{ in_array($tag->id, $post->tags->pluck('id')->toArray()) ? 'checked' : '' }}> {{ $tag->tag }}
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
                                    <input class="px-2" type="checkbox" name="categories[]" id="categories_{{ $category->id }}" value="{{ $category->id }}" {{ in_array($category->id, $post->categories->pluck('id')->toArray()) ? 'checked' : '' }}> {{ $category->category }}
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
@push('scripts')
<script src="{{ asset('vendor/summernote/summernote-bs4.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote();
    })
    function loadFile(event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
    }
</script>
@endpush
