@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Search Results</h1>

    <!-- التحقق من وجود نتائج -->
    @if($users->isEmpty())
        <p>No users found.</p>
    @else
        <!-- عرض نتائج البحث -->
        <div class="row">
            @foreach($users as $user)
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <img src="{{optional( $user->profile)->profile_picture ? asset($user->profile->profile_picture) : 'https://via.placeholder.com/100' }}" 
                                 class="rounded-circle mb-3" width="100" height="100" alt="User Image">
                            <h5 class="card-title">{{ $user->name }}</h5>
                            <a href="{{ route('profile.show', $user->id) }}" class="btn btn-primary btn-sm">View Profile</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
