@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Post</h1>

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- حقل محتوى المنشور -->
        <div class="form-group">
            <textarea class="form-control" name="content" rows="4" placeholder="What's on your mind?" required></textarea>
        </div>

        <!-- حقل تحميل الصور -->
        <div class="form-group mt-3">
            <label for="images">Upload Images</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Post</button>
    </form>
</div>
@endsection
