<head>
    <title>{{ $post->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<style>
    .container__ {
    margin: 1rem;
    }

    .comment__container {
    display: none;
    position: relative;
    margin: 20px;
    }

    .comment__container.opened {
    display: block;
    }

    .comment__container:not(:first-child) {
    margin-left: 3rem;
    margin-top: 1rem;
    }

    .comment__card {
    padding: 20px;
    background-color: white;
    border: 1px solid rgba(0, 0, 0, 0.3);
    border-radius: 0.5rem;
    min-width: 100%;
    margin: 10px;
    }

    .comment__card h3,
    .comment__card p {
    margin-bottom: 2rem;
    }

    .comment__card-footer {
    display: flex;
    font-size: 0.85rem;
    opacity: 0.6;
    justify-content: flex-end;
    align-items: center;
    cursor: pointer;
    gap: 20px;
    }

    .show-replies,
    .hover_like,
    {
    cursor: pointer;
    }
    div#social-links {
        display: inline-block;
        margin: 0;
        margin-bottom: 15px;
    }
    div#social-links a{
        font-size: 30px;
    }
</style>
<body>
    @include('includes.nav-home')
    <div class="container py-2">
        <div class="text-center">
            <h2 class="m-3">{{ $post->title }}</h3>
            <p><small class="mx-3"><b>By :</b> <i>{{ $post->created_by }}</i></small>   <i class="bi bi-eye-fill"></i> {{ $post->views }}</p>
            @if ($post->image != 'none')
                <img src="{{ asset('/storage/images/posts/'.$post->image) }}" class="img-fluid w-75">
            @else
                <img src="{{ asset('/images/hehehehe.png') }}" class="img-fluid w-25">
            @endif
            <div class="py-2">
                {!! $post->content !!}
            </div>
            @if (auth()->check())
                @if (auth()->user()->postSaves->contains('post_id', $post->id))
                    <form action="{{ route('post-saves.destroy', ['post' => $post->id]) }}" method="POST" id="post-delete-{{ $post->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-secondary btn-sm" onclick="this.disabled=true; document.getElementById('post-delete-{{ $post->id }}').submit();">Unsave</button>
                    </form>
                @else
                    <form action="{{ route('post-saves.store', ['post' => $post->id]) }}" method="POST" id="post-saves-{{$post->id}}">
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-sm" onclick="this.disabled=true; document.getElementById('post-saves-{{$post->id}}').submit();">Save</button>
                    </form>
                @endif
            @endif
            {!! $share !!}
            <div @auth onclick="event.preventDefault(); document.getElementById('like-{{ $post->id }}').submit();" @endauth>
                    <p class="hover_like">
                        <i class="fas fa-heart"></i> {{ $like }} Like
                    </p>
                <form action="{{ route('post.like', ['post' => $post->id]) }}" method="post" id="like-{{ $post->id }}" class="d-none">
                    @csrf
                </form>
            </div>
            <p class="pt-2"><a href="{{ url()->previous() }}" class="pt-3">Back</a></p>
            <hr>
        </div>
        @auth
        <label for="content"><h4>Create Comments</h4></label>

        <div class="d-flex">
            @if (auth()->user()->pp == '' || auth()->user()->pp == null)
                <img src="{{ asset('/images/null.jfif') }}" class="rounded-circle me-3" style="width:3rem;height:3rem;">
            @else
                <img class="rounded-circle me-3" style="width:3rem;height:3rem;" src="{{ asset('/storage/images/'. auth()->user()->pp) }}">
            @endif
            <div class="flex-grow-1">
               <div class="hstack gap-2 mb-1">
                  <a class="fw-bold link-dark">{{ auth()->user()->name }}</a>
               </div>
               {{-- komen 1 --}}
               <form action="{{ route('post.comment',$post->slug) }}" method="post" onsubmit="dis()" id="form-comment" class="form-floating mb-3">
                @csrf
                @method('put')
                    <textarea class="form-control w-100" placeholder="Leave a comment here" 
                    id="my-comment" 
                    style="height:7rem;" 
                    name="content" 
                    maxlength="255" 
                    oninput="document.getElementById('counter_comment').textContent = (255 - this.value.length) + ' karakter tersisa'"
                    >{{ old('content') }}</textarea>
                    <div id="counter_comment"></div>
                    <label for="my-comment">Leave a comment here</label>
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <input type="hidden" name="parent_id" value="{{ $parent_id ?? null }}">
                    <div class="hstack justify-content-end my-2">
                        <button class="btn btn-md btn-primary" type="submit" onclick="this.disabled=true; document.getElementById('form-comment').submit();">Send</button>
                    </div>
                </form>
            </div>
         </div>
        @endauth
        <h3>Comment : <hr></h3>
        @foreach ($comments as $comment)
        <div class="container__">
            @if ($comment->parent_id == null)
            <div class="comment__container opened" id="comment-{{ $comment->id }}">
                <div class="comment__card">
                    <div class="comment__title">
                        <span class="fs-5 fw-bold">
                            <img src="{{ ($comment->user->pp == null) ? asset('images/null.jfif') : asset('storage/images/'.$comment->user->pp) }}" class="rounded-circle" width="5%"> 
                            &nbsp; {{ $comment->user->name }}
                        </span>
                        <span class="fs-5">
                             - {{ $comment->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <p class="text-break">{{ $comment->content }}</p>
                    <div class="comment__card-footer">
                        @auth
                        @if ($comment->user->name == auth()->user()->name)
                        <div data-bs-toggle="collapse" data-bs-target="#editComment{{ $comment->id }}" aria-expanded="false" aria-controls="editComment{{ $comment->id }}">
                            Edit
                        </div>
                        <div class="delete-button" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $comment->id }}').submit();">
                            Delete
                        </div>
                        <form id="delete-form-{{ $comment->id }}" action="{{ route('post.comment.delete', ['comment' => $comment->id]) }}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                        @endif
                        <div data-bs-toggle="collapse" data-bs-target="#replyComment{{ $comment->id }}" aria-expanded="false" aria-controls="replyComment{{ $comment->id }}">
                            Reply
                        </div>
                        @endauth
                        <div class="show-replies">Show Reply</div>
                    </div>
                    <div class="collapse" id="editComment{{ $comment->id }}">
                        {{-- update --}}
                        <form action="{{ route('post.comment.update', ['comment' => $comment->id]) }}" method="POST" id="comment-update-{{ $comment->id }}">
                          @csrf
                          @method('PUT')
                          <div class="mb-3">
                            <textarea 
                            class="form-control" 
                            id="content" 
                            name="content" 
                            class="form-control" 
                            maxlength="255" 
                            oninput="document.getElementById('counter_edit{{ $comment->id }}').textContent = (255 - this.value.length) + ' karakter tersisa'"
                            >{{ $comment->content }}</textarea>
                            <div id="counter_edit{{ $comment->id }}"></div>
                          </div>
                          @error('content')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                          @auth
                          <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                          @endauth
                          <input type="hidden" name="post_id" value="{{ $post->id }}">
                          <button type="submit" class="btn btn-primary" onclick="this.disabled=true; document.getElementById('comment-update-{{ $comment->id }}').submit();">Update</button>
                        </form>
                    </div>
                    {{-- reply comment --}}
                    <div class="collapse" id="replyComment{{ $comment->id }}">
                        <form action="{{ route('post.comment', ['post' => $post->slug]) }}" method="POST" id="comment-reply-{{ $comment->id }}">
                          @csrf
                          @method('PUT')
                          <div class="mb-3">
                            <textarea 
                            class="form-control" 
                            id="content" 
                            name="content"
                            maxlength="255" 
                            oninput="document.getElementById('counter_reply_comment{{ $comment->id }}').textContent = (255 - this.value.length) + ' karakter tersisa'"
                            >{{ __('@:username ', ['username' => $comment->user->name]) }}</textarea>
                            <div id="counter_reply_comment{{ $comment->id }}"></div>
                          </div>
                          @error('content')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                          @auth
                          <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                          @endauth
                          <input type="hidden" name="post_id" value="{{ $post->id }}">
                          <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                          <button type="submit" class="btn btn-primary" onclick="this.disabled=true; document.getElementById('comment-reply-{{ $comment->id }}').submit();">Send</button>
                        </form>
                    </div>
                </div>
                <div class="comment__container" dataset="comment-{{ $comment->id }}" id="reply-{{ $comment->id }}">
                    @if(count($comment->replies))
                    @foreach ($comment->replies as $reply)
                    <div class="comment__card">
                        <div class="comment__title">
                            <span class="fs-5 fw-bold">
                                <img src="{{ ($reply->user->pp == null) ? asset('images/null.jfif') : asset('storage/images/'.$reply->user->pp) }}" class="rounded-circle" width="5%"> 
                                &nbsp; {{ $reply->user->name }}
                            </span> 
                            <span class="fs-5">
                                - {{ $reply->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-break">{{ $reply->content }}</p>
                        <div class="comment__card-footer">
                            @auth
                            @if ($reply->user->name == auth()->user()->name)
                            <div data-bs-toggle="collapse" data-bs-target="#editReplyComment{{ $reply->id }}" aria-expanded="false" aria-controls="editReplyComment{{ $reply->id }}">
                                Edit
                            </div>
                            <div class="delete-button" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $reply->id }}').submit();">
                                Delete
                            </div>
                            <form id="delete-form-{{ $reply->id }}" action="{{ route('post.comment.delete', ['comment' => $reply->id]) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                            @endif
                            <div data-bs-toggle="collapse" data-bs-target="#replyReplyComment{{ $reply->id }}" aria-expanded="false" aria-controls="replyReplyComment{{ $reply->id }}">
                                Reply
                            </div>
                            @endauth
                            <div class="show-replies">Show Reply</div>
                        </div>
                        <div class="collapse" id="editReplyComment{{ $reply->id }}">
                            {{-- update --}}
                            <form action="{{ route('post.comment.update', ['comment' => $reply->id]) }}" method="POST" id="comment-reply-update-{{ $reply->id }}">
                              @csrf
                              @method('PUT')
                              <div class="mb-3">
                                <textarea class="form-control" id="content" name="content" class="form-control" maxlength="255" 
                                oninput="document.getElementById('update_reply_counter_{{ $reply->id }}').textContent = (255 - this.value.length) + ' karakter tersisa'"
                                >{{ $reply->content }}</textarea>
                                <div id="update_reply_counter_{{ $reply->id }}"></div>
                              </div>
                              @error('content')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                              @auth
                              <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                              @endauth
                              <input type="hidden" name="post_id" value="{{ $post->id }}">
                              <button type="submit" class="btn btn-primary" onclick="this.disabled=true; document.getElementById('comment-reply-update-{{ $reply->id }}').submit();">Update</button>
                            </form>
                        </div>
                        {{-- reply --}}
                        <div class="collapse" id="replyReplyComment{{ $reply->id }}">
                            <form action="{{ route('post.comment', ['post' => $post->slug]) }}" method="POST" id="comment-reply-reply-{{ $reply->id }}">
                              @csrf
                              @method('PUT')
                              <div class="mb-3">
                                <textarea autofocus class="form-control" id="content" name="content" maxlength="255" 
                                oninput="document.getElementById('reply_reply_counter_{{ $reply->id }}').textContent = (255 - this.value.length) + ' karakter tersisa'"
                                >{{ __('@:username ', ['username' => $reply->user->name]) }}</textarea>
                                <div id="reply_reply_counter_{{ $reply->id }}"></div>
                              </div>
                              @error('content')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                              @auth
                              <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                              @endauth
                              <input type="hidden" name="post_id" value="{{ $post->id }}">
                              <input type="hidden" name="parent_id" value="{{ $reply->id }}">
                              <button type="submit" class="btn btn-primary" onclick="this.disabled=true; document.getElementById('comment-reply-reply-{{ $reply->id }}').submit();">Send</button>
                            </form>
                        </div>
                    </div>
                    <div class="comment__container"  dataset="reply-{{ $comment->id }}" id="reply-reply-{{ $reply->id }}">
                    @if ($reply->replies)
                        @foreach ($reply->replies as $reply2)
                            <div class="comment__card">
                                <div class="comment__title">
                                    <span class="fs-5 fw-bold">
                                        <img src="{{ ($reply2->user->pp == null) ? asset('images/null.jfif') : asset('storage/images/'.$reply2->user->pp) }}" class="rounded-circle" width="5%"> 
                                        &nbsp; {{ $reply2->user->name }}
                                    </span> 
                                    <span class="fs-5">
                                        - {{ $reply2->created_at->diffForHumans() }}
                                    </span>
                                    </div>
                                <p class="text-break">{{ $reply2->content }}</p>
                                <div class="comment__card-footer">
                                    @auth
                                    @if ($reply2->user->name == auth()->user()->name)
                                    <div data-bs-toggle="collapse" data-bs-target="#editReplyReplyComment{{ $reply2->id }}" aria-expanded="false" aria-controls="editReplyReplyComment{{ $reply2->id }}">
                                        Edit
                                    </div>
                                    <div class="delete-button" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $reply2->id }}').submit();">
                                        Delete
                                    </div>
                                    <form id="delete-form-{{ $reply2->id }}" action="{{ route('post.comment.delete', ['comment' => $reply2->id]) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    @endif
                                    @endauth
                                </div>
                                {{-- edit --}}
                                <div class="collapse" id="editReplyReplyComment{{ $reply2->id }}">
                                    <form action="{{ route('post.comment.update', ['comment' => $reply2->id]) }}" method="POST" id="comment-reply2-{{$reply2->id}}">
                                      @csrf
                                      @method('PUT')
                                      <div class="mb-3">
                                        <textarea class="form-control" id="content" name="content" maxlength="255" class="form-control" oninput="document.getElementById('edit_reply_reply_counter_{{ $reply2->id }}').textContent = (255 - this.value.length) + ' karakter tersisa'">{{ $reply2->content }}</textarea>
                                        <div id="edit_reply_reply_counter_{{ $reply2->id }}"></div>
                                      </div>
                                      @error('content')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                      @auth
                                      <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                      @endauth
                                      <input type="hidden" name="post_id" value="{{ $post->id }}">
                                      <button type="submit" class="btn btn-primary" onclick="this.disabled=true; document.getElementById('comment-reply2-{{$reply2->id}}').submit();">Update</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
            @endif
        </div>
        @endforeach
        <div class="row">
            <div class="col-md-6">
                <h4>Category : </h4>
                @foreach ($post->categories as $category)
                    <a href="{{ route('post.category', $category->id) }}" class="mb-2 float-start">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
<script src="{{ asset('js/share.js') }}"></script>
<script>
    function dis() {
        document.getElementById('btn-submit').setAttribute('disabled', true);
    }
    const showContainers = document.querySelectorAll(".show-replies");
    showContainers.forEach((btn) =>
    btn.addEventListener("click", (e) => {
        let parentContainer = e.target.closest(".comment__container");
        let _id = parentContainer.id;
        if (_id) {
        let childrenContainer = parentContainer.querySelectorAll(
            `[dataset=${_id}]`
        );
        childrenContainer.forEach((child) => child.classList.toggle("opened"));
        }
    })
    );
    function countWords() {
        const input = document.getElementById("my-comment");
        const counter = document.getElementById("counter");
        const sisa = 255 - input.value.length;
        counter.textContent = sisa + " karakter tersisa";
    }
</script>