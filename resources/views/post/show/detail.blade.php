<head>
    <title>{{ $post->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    @include('includes.nav-home')
    <div class="container py-2">
        <div class="text-center">
            <h1 class="m-3">{{ $post->title }}</h1>
            @if ($post->image != 'none')
                <img src="{{ asset('/storage/images/posts/'.$post->image) }}" class="img-fluid w-50">
            @else
                <img src="{{ asset('/images/hehehehe.png') }}" class="img-fluid w-25">
            @endif
            <h4 class="pt-3">{!! $post->content !!}</h4>
            @foreach ($post->categories as $category)
                <a href="/post/category/{{ $category->id }}" class="btn btn-outline-dark btn-sm">{{ $category->category }}</a>
            @endforeach        
            <p class="pt-2"><a href="{{ url()->previous() }}" class="pt-3">Back</a></p>
            <hr>
            @auth
        </div>
        <label for="content"><h4>Create Comments</h4></label>
        <form action="{{ route('post.comment',$post->slug) }}" method="post" onsubmit="dis()" id="form-comment">
        @csrf
        @method('put')
        @honeypot
            <textarea type="text" name="content" id="content" placeholder="..." class="form-control mb-3 @error('content') is-invalid @enderror"></textarea>
            @error('content')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
            <input type="hidden" name="post_id" value="{{ $post->id }}">
        <button type="submit" class="btn btn-primary mb-3" id="btn-submit">Submit</button>
        </form>
        @endauth

        <div class="container text-dark">
        @foreach ($comments as $comment)
            <div class="d-flex flex-start">
            @if ($comment->user->pp == '' || $comment->user->pp == null)
                <img src="{{ asset('/images/null.jfif') }}" class="rounded-circle shadow-1-strong me-3" width="60" height="60">
            @else
                <img src="{{ asset('/storage/images/'.$comment->user->pp) }}" class="rounded-circle shadow-1-strong me-3" width="60" height="60">
            @endif
              <div>
                <h6 class="fw-bold mb-1">{{ $comment->user->name }}</h6>
                <div class="d-flex align-items-center mb-3">
                  <p class="mb-0">{{ $comment->created_at->diffForHumans() }}</p>
                </div>
                {{ $comment->content }}
              </div>
            </div>
            <hr class="my-3">
        @endforeach
        </div>


        @foreach ($post->tags as $tag)
            <p class="text-center"><a href="{{ route('post.tag',$tag->id) }}">#{{ $tag->tag }}</a></p>
        @endforeach

    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    function dis() {
        document.getElementById('btn-submit').setAttribute('disabled', true);
    }
</script>