@extends('layouts.app')

@section('title', 'لیست پست‌ها')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">لیست پست‌ها</h2>
    {{-- <a href="{{ route('posts.create') }}" class="btn btn-primary">پست جدید</a> --}}
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- <div class="mb-4">
    <form method="GET" action="{{ route('posts.index') }}">
        <input type="text" name="search" class="form-control search-bar" placeholder="جستجوی پست..." value="{{ request('search') }}">
    </form>
</div> --}}

<div class="row g-4">
    @forelse($posts as $post)
        <div class="col-md-4">
            <div class="card restaurant-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p class="card-text text-truncate">{{ $post->content }}</p>
                    <p class="mb-1"><strong>نویسنده:</strong> {{ $post->user?->name }}</p>
                    <p class="mb-3"><strong>وضعیت:</strong> {{ $post->published ? 'منتشر شده' : 'پیش‌نویس' }}</p>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-warning">ویرایش</a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="confirmDelete(event)">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">حذف</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p class="text-center">هیچ پستی وجود ندارد.</p>
    @endforelse
</div>
@endsection
