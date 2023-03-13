<head>
    <title>Saved</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body>
    @include('includes.nav-home')
    <div class="container py-2">
        <div class="row">
        @foreach ($postsaves as $post)
            <div class="col-md-4 my-2">
                <div class="card">
                    @if ($post->post->image != 'none')
                        <img src="{{ asset('/storage/images/posts/'.$post->post->image) }}" class="card-img-top img-fluid" style="max-height: 230px">
                    @else
                        <img src="{{ asset('/images/hehehehe.png') }}" class="card-img-top img-fluid" style="max-height: 230px">
                    @endif
                    <div class="card-body">
                        <h4 class="card-title text-truncate">
                            {{ $post->post->title }}
                        </h4>
                        <p class="card-text text-truncate">
                            {!! $post->post->content !!}
                        </p>
                        <p class="card-text">by: {{ $post->post->created_by }}</p>
                        <small class="text-muted float-end"><i class="bi bi-eye-fill"></i> {{ $post->post->views }}</small>
                    </div>
                        <a href="/posts/{{ $post->post->slug }}" class="card-footer text-center">Read More</a>
                </div>
            </div>
        @endforeach
    </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>