@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Newsfeed</h1>
        <a href="{{ route('posts.create') }}" class="btn btn-primary">Create Post</a>
    </div>

    @foreach ($posts as $post)
    <div class="card mb-4 shadow-sm" id="post-{{ $post->id }}">
        <div class="card-body p-3">
            <div class="d-flex align-items-center mb-3">
                <img src="{{ optional($post->user->profile)->profile_picture ? asset($post->user->profile->profile_picture) : 'https://via.placeholder.com/50' }}" class="rounded-circle me-3" width="50" height="50" alt="User Image">
                <div>
                    <h5 class="mb-0">{{ $post->user->name }}</h5>
                    <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                </div>
            </div>

            <p class="card-text mb-3">{{ $post->content }}</p>

            @if ($post->images && $post->images->count() > 0)
                <div class="row mb-3">
                    @foreach ($post->images as $image)
                        <div class="col-md-4 mb-2">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal{{ $image->id }}">
                                <img src="{{ asset($image->image_path) }}" class="card-img-top" alt="Post Image" style="height: 200px; object-fit: cover;">
                            </a>
                        </div>

                        <div class="modal fade" id="imageModal{{ $image->id }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $image->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-body p-0">
                                        <img src="{{ asset($image->image_path) }}" class="img-fluid" alt="Post Image" style="width: 100%;">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="me-2 likes-count">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#likesModal{{ $post->id }}" class="text-decoration-none">
                            <span class="likes-number">{{ $post->likes->count() }}</span> <i class="fas fa-thumbs-up text-primary"></i>
                        </a>
                    </span>
                    <span><span class="comments-count">{{ $post->comments->count() }}</span> Comments</span>
                </div>
            </div>

            <hr>

            <div class="d-flex justify-content-around mb-3">
               <form
    action="{{ route($post->isLikedBy(auth()->user()) ? 'post.unlike' : 'post.like', $post->id) }}"
    method="POST"
    class="me-2 like-form"
    data-liked="{{ $post->isLikedBy(auth()->user()) ? 1 : 0 }}"
>
    @csrf
    <button
        type="button"
        class="btn btn-light btn-block text-primary"
        data-post-id="{{ $post->id }}"
    >
        @if ($post->isLikedBy(auth()->user()))
            <i class="fas fa-thumbs-down"></i> Unlike
        @else
            <i class="fas fa-thumbs-up"></i> Like
        @endif
    </button>
</form>

                <button class="btn btn-light btn-block  comment-hiden">
                    <i class="fas fa-comment"></i> Comment
                </button>
            </div>

            @if ($post->comments->count() > 0)
                <div class="comments mb-3">
                    @foreach ($post->comments as $comment)
                        <div class="d-flex align-items-center mb-2">
                            <img src="{{ optional($comment->user->profile)->profile_picture ? asset($comment->user->profile->profile_picture) : 'https://via.placeholder.com/40' }}" 
                                 class="rounded-circle me-2" width="40" height="40" alt="User Image">
                            <div class="bg-light p-2 rounded" style="flex-grow: 1;">
                                <strong>{{ $comment->user->name }}</strong> <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                <p class="mb-0">{{ $comment->content }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="comments mb-3"></div>
            @endif

            <form action="{{ route('post.comment', $post->id) }}" method="POST" class="comment-form">
                @csrf
                <div class="form-group mb-2">
                    <textarea class="form-control comment-textarea" name="content" rows="2" placeholder="Write a comment..." required></textarea>
                </div>
                <button type="submit" class="btn btn-light btn-sm">
                    <i class="fas fa-paper-plane"></i> Post Comment
                </button>
            </form>
        </div>
    </div>

    <div class="modal fade" id="likesModal{{ $post->id }}" tabindex="-1" aria-labelledby="likesModalLabel{{ $post->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="likesModalLabel{{ $post->id }}">People who liked this post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group likes-list">
                        @foreach ($post->likes as $like)
                        <li class="list-group-item d-flex align-items-center">
                            <img src="{{ $like->user->profile && $like->user->profile->profile_picture ? asset($like->user->profile->profile_picture) : 'https://via.placeholder.com/40' }}" 
                                 class="rounded-circle me-2" width="40" height="40" alt="User Image">
                            <span>{{ $like->user->name }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

@push('scripts')
@vite(['resources/js/newsfeed-realtime.js'])
@endpush