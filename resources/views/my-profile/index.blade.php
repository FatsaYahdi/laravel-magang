@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">{{ __('Edit Profile') }}</div>
                    <div class="card-body">
                        <form
                            action="{{ route('my.profile.update') }}"
                            method="POST"
                            enctype="multipart/form-data"
                        >
                            @method('put')
                            @csrf
                            {{-- Name --}}
                            <div class="row mb-3">
                                <label
                                    for="name"
                                    class="col-md-4 col-form-label text-md-end"
                                >{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input
                                        id="name"
                                        type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        name="name"
                                        value="{{ old('name', auth()->user()->name) }}"
                                    >

                                    @error('name')
                                        <span
                                            class="invalid-feedback"
                                            role="alert"
                                        >
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- Tanggal Lahir --}}
                            <div class="row mb-3">
                                <label
                                    for="birth"
                                    class="col-md-4 col-form-label text-md-end"
                                >{{ __('Tanggal Lahir') }}</label>

                                <div class="col-md-6">
                                    <input
                                        id="birth"
                                        type="date"
                                        class="form-control @error('birth') is-invalid @enderror"
                                        name="birth"
                                        value="{{ old('birth', auth()->user()->birth) }}"
                                    >

                                    @error('birth')
                                        <span
                                            class="invalid-feedback"
                                            role="alert"
                                        >
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- Jenis Kelamin --}}
                            <div class="row mb-3">
                                <label
                                    for="gender"
                                    class="col-md-4 col-form-label text-md-end"
                                >{{ __('Jenis Kelamin') }}</label>

                                <div class="col-md-6">
                                    <select
                                        class="form-control @error('gender') is-invalid @enderror"
                                        aria-label="Default select example"
                                        name="gender"
                                    >
                                        <option
                                            {{ old('gender', auth()->user()->gender) === "man" ? 'selected' : '' }}
                                            value="man"
                                        >Pria</option>
                                        <option
                                            {{ old('gender', auth()->user()->gender) === "woman" ? 'selected' : '' }}
                                            value="woman"
                                        >Wanita</option>
                                        <option
                                            {{ old('gender', auth()->user()->gender) === 'secret' ? 'selected' : '' }}
                                            value="secret"
                                        >Rahasia</option>
                                    </select>

                                    @error('gender')
                                        <span
                                            class="invalid-feedback"
                                            role="alert"
                                        >
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- Alamat --}}
                            <div class="row mb-3">
                                <label
                                    for="address"
                                    class="col-md-4 col-form-label text-md-end"
                                >{{ __('Alamat') }}</label>

                                <div class="col-md-6">
                                    <textarea
                                        id="address"
                                        type="text"
                                        class="form-control @error('address') is-invalid @enderror"
                                        name="address"
                                    >{{ old('address', auth()->user()->address) }}</textarea>

                                    @error('address')
                                        <span
                                            class="invalid-feedback"
                                            role="alert"
                                        >
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- images --}}
                            <div class="row mb-2">
                                <label
                                    for="pp"
                                    class="col-md-4 col-form-label text-md-end"
                                >{{ __('Foto') }}</label>
                                <div class="col-md-6">
                                    <div class="input-group mb-1">
                                        <div>
                                            <input
                                                name="pp"
                                                class="form-control @error('pp') is-invalid @enderror"
                                                value="{{ old('pp', auth()->user()->pp) }}"
                                                type="file"
                                                accept="image/*"
                                                id="formFile"
                                                onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])"
                                            >
                                                <img src="" class="output mt-2" id="output" width="150px">
                                        </div>
                                    </div>
                                    @error('pp')
                                        <span
                                            class="invalid-feedback"
                                            role="alert"
                                        >
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- Save --}}
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button
                                        type="submit"
                                        class="btn btn-dark"
                                    >
                                        {{ __('Save') }}
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