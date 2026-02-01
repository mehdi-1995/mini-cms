@extends('layouts.app')

@section('title', 'صفحه اصلی')

@section('content')
<div class="text-center mt-5">
    <h1 class="mb-4">خوش آمدید به مینی CMS!</h1>
    <p class="lead mb-4">این یک سیستم مدیریت محتوا سبک با قابلیت Role و Permission است.</p>
    <div class="d-flex justify-content-center gap-3 flex-wrap">
        <a href="{{ route('posts.index') }}" class="btn btn-primary btn-lg">مشاهده پست‌ها</a>
        <a href="{{ route('dashboard') }}" class="btn btn-success btn-lg">داشبورد</a>
    </div>
</div>

<div class="row mt-5 g-4">
    <div class="col-md-4">
        <div class="card restaurant-card shadow-sm p-3">
            <h5 class="card-title">پست‌ها</h5>
            <p class="card-text">ایجاد، ویرایش و مدیریت پست‌ها</p>
            <a href="{{ route('posts.index') }}" class="btn btn-outline-primary">مشاهده</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card restaurant-card shadow-sm p-3">
            <h5 class="card-title">کاربران</h5>
            <p class="card-text">مدیریت کاربران و نقش‌ها</p>
            <a href="#" class="btn btn-outline-primary">مشاهده</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card restaurant-card shadow-sm p-3">
            <h5 class="card-title">تنظیمات</h5>
            <p class="card-text">پیکربندی سیستم و دسترسی‌ها</p>
            <a href="#" class="btn btn-outline-primary">مشاهده</a>
        </div>
    </div>
</div>
@endsection
