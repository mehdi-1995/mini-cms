@extends('layouts.app')

@section('title', 'ویرایش پست')

@section('content')
<h2 class="mb-4">ویرایش پست</h2>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- <form action="{{ route('posts.update', $post) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="title" class="form-label">عنوان</label>
        <input type="text" name="title" class="form-control" value="{{ $post->title }}" required>
    </div>
    <div class="mb-3">
        <label for="content" class="form-label">محتوا</label>
        <textarea name="content" class="form-control" rows="6" required>{{ $post->content }}</textarea>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" name="published" class="form-check-input" id="published" {{ $post->published ? 'checked' : '' }}>
        <label class="form-check-label" for="published">منتشر شود</label>
    </div>
    <button type="submit" class="btn btn-warning">ویرایش</button>
</form> --}}

@endsection