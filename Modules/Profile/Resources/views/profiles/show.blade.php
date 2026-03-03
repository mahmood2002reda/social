@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">{{ $user->name }}'s Profile</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                        <div class="col-md-4 text-center">
                            <img src="{{ optional($user->profile)->profile_picture ? asset(  $user->profile->profile_picture) : asset('images/default-avatar.png') }}" class="img-fluid rounded-circle mb-3" alt="Profile Picture">                   </div>
                        </div>
                        <div class="col-md-8">
                            <h4 class="card-title">Bio</h4>
                            <p class="card-text">{{ optional($user->profile)->bio ?? 'لا يوجد نبذة شخصية' }}</p>

                            @if (auth()->user()->id == $user->id)
                                <a href="{{ route('profile.edit', $user->id) }}" class="btn btn-warning">Edit Profile</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
