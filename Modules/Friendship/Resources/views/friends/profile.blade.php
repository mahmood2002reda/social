@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-3 shadow-sm">
                <div class="card-body text-center">
                    <img src="{{optional($user->profile)->profile_picture ? asset($user->profile->profile_picture) : 'https://via.placeholder.com/150' }}" 
                         class="rounded-circle mb-3" width="150" height="150" alt="User Image">
                    
                    <h4>{{ $user->name }}</h4>
                    
                    <p>{{ optional($user->profile)->bio }}</p>

                    @if (auth()->user()->id !== $user->id)
                        @php
                            $friendship = auth()->user()->sentFriendRequests()
                                              ->where('friend_id', $user->id)
                                              ->orWhere(function ($query) use ($user) {
                                                  $query->where('user_id', $user->id)
                                                        ->where('friend_id', auth()->user()->id);
                                              })
                                              ->first();

                            $isFriend = auth()->user()->friends->contains($user->id);
                        @endphp

                        @if ($isFriend)
                            <form action="{{ route('friend.unfriend', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Unfriend</button>
                            </form>
                        @elseif ($friendship && !$friendship->accepted)
                            <form action="{{ route('friend.cancel', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Cancel Friend Request</button>
                            </form>
                        @elseif (!$friendship)
                            <form action="{{ route('friend.request', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Send Friend Request</button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <h3>{{ $user->name }}'s Posts</h3>

            @forelse($posts as $post)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->user->name }}</h5>
                        <p class="card-text">{{ $post->content }}</p>

            @if ($post->images && $post->images->count() > 0)
                <div class="row mb-3">
                    @foreach ($post->images as $image)
                        <div class="col-md-4 mb-2">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal{{ $image->id }}">
                    <img src="{{ asset($image->image_path) }}" class="card-img-top" alt="Post Image" style="height: 200px; object-fit: cover;">                            </a>
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
            @endif                        <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            @empty
                <p>{{ $user->name }} has not posted anything yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
