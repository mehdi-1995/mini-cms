@extends('layouts.app')

@section('title', 'ایجاد پست')

@section('content')
<h2 class="mb-4">ایجاد پست جدید</h2>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="#" method="POST">
{{-- <form action="{{ route('posts.store') }}" method="POST"> --}}
    @csrf
    <div class="mb-3">
        <label for="title" class="form-label">عنوان</label>
        <input type="text" name="title" class="form-control" placeholder="عنوان پست" required>
    </div>
    <div class="mb-3">
        <label for="content" class="form-label">محتوا</label>
        <textarea name="content" class="form-control" rows="6" placeholder="متن پست..." required></textarea>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" name="published" class="form-check-input" id="published">
        <label class="form-check-label" for="published">منتشر شود</label>
    </div>
    <button type="submit" class="btn btn-success">ذخیره</button>
</form>
@endsection
