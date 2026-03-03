@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Your Profile</h1>
    
    <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="bio">Bio</label>
            <textarea class="form-control" name="bio" placeholder="Tell us about yourself"></textarea>
        </div>
        <div class="form-group">
            <label for="profile_picture">Profile Picture</label>
            <input type="file" class="form-control" name="profile_picture">
        </div>
        <button type="submit" class="btn btn-primary mt-3">Save Profile</button>
    </form>
</div>
@endsection
