@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Friend Requests</h1>

    @if($friendRequests->isEmpty())
        <p>No friend requests at the moment.</p>
    @else
        <ul class="list-group">
            @foreach($friendRequests as $request)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <!-- اسم المستخدم الذي أرسل الطلب -->
                    {{ $request->user->name }}
                    
                    <!-- أزرار قبول أو رفض الطلب -->
                    <div>
                        <form action="{{ route('friend.accept', $request->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Accept</button>
                        </form>

                        <form action="{{ route('friend.reject', $request->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
