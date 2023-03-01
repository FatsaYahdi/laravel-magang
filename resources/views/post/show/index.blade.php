<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        

        <!-- Styles -->
        

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
            
            </style>
        <link href="css/carousel.css" rel="stylesheet">
        <link href="{{ asset('css/index.css') }}" rel="stylesheet">
    </head>


    <body class="antialiased">
        @include('includes.nav-home')
            @if(request()->query('page') == null || request()->query('page') == '1')
            @if(!Route::is('post.category') && !Route::is('post.tag'))
                <div class="mx-auto sm:px-6 lg:px-5">
                    <div id="carouselExample" class="carousel slide w-100">
                        <div class="carousel-inner pt-3">
                            @foreach ($pinnedPosts as $post)
                                <div class="carousel-item @if ($loop->first) active @endif">
                                    @if ($post->image != 'none')
                                        <img src="{{ asset('/storage/images/posts/'.$post->image) }}" class="d-block w-100 img-fluid" alt="{{ $post->title }}" style="filter: brightness(50%)">
                                    @else
                                        <img src="{{ asset('/images/hehehehe.png') }}" class="d-block w-100 img-fluid" alt="{{ $post->title }}" style="filter: brightness(50%)">
                                    @endif
                                    <div class="container">
                                        <div class="carousel-caption">
                                            <h2>{{ $post->title }}</h1>
                                            <h6>{!! $post->content !!}</h6>
                                            <a href="/posts/{{ $post->slug }}" class="btn btn-primary">Read More</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="visually-hidden">Next</span>
                        </button>
                    </div>
            @endif
            @endif

                    <div class="container">
                        <div class="row">
                            @foreach ($posts as $post)
                                <div class="col-md-4 my-2">
                                    <div class="card">
                                        @if ($post->image != 'none')
                                            <img src="{{ asset('/storage/images/posts/'.$post->image) }}" class="card-img-top img-fluid" style="max-height: 230px">
                                        @else
                                            <img src="{{ asset('/images/hehehehe.png') }}" class="card-img-top img-fluid" style="max-height: 230px">
                                        @endif
                                        <div class="card-body">
                                            <h4 class="card-title text-truncate">
                                                {{ $post->title }}
                                            </h4>
                                            <p class="card-text text-truncate">
                                                {!! $post->content !!}
                                            </p>
                                            <p class="card-text">by: {{ $post->created_by }}</p>
                                            <small class="text-muted float-end"><i class="bi bi-eye-fill"></i> {{ $post->views }}</small>
                                            <p>
                                                @foreach($post->categories as $category)
                                                    <p class="card-text">
                                                        <a href="{{ route('post.category', $category->id) }}">
                                                            {{ $category->category }}
                                                        </a>
                                                    </p>
                                                @endforeach
                                            </p>
                                        </div>
                                            <a href="/posts/{{ $post->slug }}" class="card-footer text-center">Read More</a>
                                    </div>
                                </div>
                            @endforeach
                            <div class="d-flex justify-content-center my-4">
                                @if (!Route::is('post.category') && !Route::is('post.tag'))
                                    @if (!empty($posts))
                                        <div>{{ $posts->links() }}</div>
                                    @endif
                                @endif
                            </div>
                            <footer class="footer">
                                @if (!Route::is('post.category') && !Route::is('post.tag'))
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul style="list-style: none;">
                                                    @foreach ($tags as $tag)
                                                        <li><a href="{{ route('post.tag',$tag->id) }}"><h5>#{{ $tag->tag }}</h5></a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </footer>
                        </div>
                    </div>
            
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>