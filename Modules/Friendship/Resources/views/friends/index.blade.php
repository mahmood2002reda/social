@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $user->name }}'s Friends</h1>

    @if($friends->isEmpty())
        <p>No friends yet.</p>
    @else
        <ul class="list-group">
            @foreach($friends as $friend)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <!-- عرض اسم الصديق -->
                    {{ $friend->name }}

                    <!-- زر لعرض الملف الشخصي للصديق -->
                    <a href="{{ route('profile.show', $friend->id) }}" class="btn btn-primary btn-sm">View Profile</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
