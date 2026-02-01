@extends('layouts.app')

@section('title', 'داشبورد')

@section('content')
<h2 class="mb-4">داشبورد سیستم</h2>

<div class="row g-4">
    <div class="col-md-3">
        <div class="card restaurant-card shadow-sm p-3 text-center">
            <h5 class="card-title">کل پست‌ها</h5>
            <p class="display-5 fw-bold">{{ $totalPosts }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card restaurant-card shadow-sm p-3 text-center">
            <h5 class="card-title">پست‌های منتشر شده</h5>
            <p class="display-5 fw-bold text-success">{{ $publishedPosts }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card restaurant-card shadow-sm p-3 text-center">
            <h5 class="card-title">پست‌های پیش‌نویس</h5>
            <p class="display-5 fw-bold text-warning">{{ $draftPosts }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card restaurant-card shadow-sm p-3 text-center">
            <h5 class="card-title">کل کاربران</h5>
            <p class="display-5 fw-bold text-primary">{{ $totalUsers }}</p>
        </div>
    </div>
</div>
@endsection
