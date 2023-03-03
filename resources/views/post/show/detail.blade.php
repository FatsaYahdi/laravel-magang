<head>
    <title>{{ $post->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>
<body>
    @include('includes.nav-home')
    <div class="container py-2">
        <div class="text-center">
            <h1 class="m-3">{{ $post->title }}</h1>
            <p class="float-end"><i class="bi bi-eye-fill"></i> {{ $post->views }}</p>
            @if ($post->image != 'none')
                <img src="{{ asset('/storage/images/posts/'.$post->image) }}" class="img-fluid w-50">
            @else
                <img src="{{ asset('/images/hehehehe.png') }}" class="img-fluid w-25">
            @endif
            <h4 class="pt-3">{!! $post->content !!}</h4>
            <p class="pt-2"><a href="{{ url()->previous() }}" class="pt-3">Back</a></p>
            <hr>
        </div>
        @auth
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

        @foreach ($comments as $comment)
            <div class="d-flex flex-start position-relative">
            @if ($comment->user->pp == '' || $comment->user->pp == null)
                <img src="{{ asset('/images/null.jfif') }}" class="rounded-circle shadow-1-strong me-3" width="60" height="60">
            @else
                <img src="{{ asset('/storage/images/'.$comment->user->pp) }}" class="rounded-circle shadow-1-strong me-3" width="60" height="60">
            @endif
              <div>
                <div><span class="fw-bold">{{ $comment->user->name }}</span> | <small class="mb-0">{{ $comment->created_at->diffForHumans() }}</small>
                    @if($comment->user->name == auth()->user()->name)
                    <div class="dropdown position-absolute top-0 end-0">
                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @if($comment->user->name == auth()->user()->name)
                            <li>
                                <button type="button" class="btn btn-link btn-sm dropdown-item" data-bs-toggle="collapse" data-bs-target="#editComment{{ $comment->id }}" aria-expanded="false" aria-controls="editComment{{ $comment->id }}">
                                    Edit
                                </button>
                            </li>
                            <li>
                                <form action="{{ route('post.comment.delete', ['comment' => $comment->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link btn-sm dropdown-item">Delete</button>
                                </form>
                            </li>
                            @endif
                        </ul>
                    </div>
                    @endif
                </div>
                <div class="d-flex align-items-center mb-1">
                  {{ $comment->content }}
                </div>
                <div class="collapse" id="editComment{{ $comment->id }}">
                    <form action="{{ route('post.comment.update', ['comment' => (int) $comment->id]) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="mb-3">
                        <textarea class="form-control" id="content" name="content" class="form-control">{{ $comment->content }}</textarea>
                      </div>
                      @error('content')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                      <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                      <input type="hidden" name="post_id" value="{{ $post->id }}">
                      <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
              </div>
            </div>
            <hr class="my-3">
        @endforeach


        <div class="row">
            <div class="col-md-6">
                <h4>Category : </h4>
                @foreach ($post->categories as $category)
                    <a href="{{ route('post.category', $category->id) }}" class="btn btn-sm btn-outline-secondary mb-2 float-start">
                        {{ $category->category }}
                    </a>
                @endforeach
            </div>
            <div class="col-md-6">
                <h4>Tag : </h4>
                @foreach ($post->tags as $tag)
                    <p class="mb-0"><a href="{{ route('post.tag', $tag->id) }}" class="float-start">#{{ $tag->tag }}</a></p>
                @endforeach
            </div>
        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    function dis() {
        document.getElementById('btn-submit').setAttribute('disabled', true);
    }
</script>