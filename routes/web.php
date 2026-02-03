<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

######################################
# 🏠 Public / Home
######################################
Route::get('/', [HomeController::class, 'index'])->name('home');


######################################
# 👤 Authenticated Users (web guard)
######################################
Route::middleware(['auth','verified'])->group(function () {

    // داشبورد کاربر
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // نمایش پست‌ها (همه‌ی لاگین شده‌ها)
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

    // مدیریت پست‌ها برای نقش‌های مجاز
    Route::middleware('role:editor|author')->group(function () {
        Route::prefix('posts')->as('posts.')->group(function () {
            Route::get('/create', [PostController::class, 'create'])->name('create');
            Route::post('/', [PostController::class, 'store'])->name('store');
            Route::get('/{post}/edit', [PostController::class, 'edit'])->name('edit');
            Route::put('/{post}', [PostController::class, 'update'])->name('update');
            Route::delete('/{post}', [PostController::class, 'destroy'])->name('destroy');
        });
    });
});


######################################
# 🛡 Admin Guard
######################################
Route::prefix('admin')->as('admin.')->group(function () {

    // ورود ادمین
    Route::get('/login', [AdminAuthController::class,'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class,'login']);

    Route::middleware('auth:admin')->group(function () {

        // داشبورد ادمین
        Route::get('/dashboard', [AdminDashboardController::class,'index'])->name('dashboard');

        // خروج
        Route::post('/logout', [AdminAuthController::class,'logout'])->name('logout');

        // کاربران
        Route::prefix('users')->as('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        });

        // نقش‌ها
        Route::prefix('roles')->as('roles.')->middleware('role:admin|super-admin')->group(function () {
            Route::get('/', [RoleController::class,'index'])->name('index');
            Route::get('/create', [RoleController::class,'create'])->name('create');
            Route::post('/', [RoleController::class,'store'])->name('store');
            Route::get('/{role}/edit', [RoleController::class,'edit'])->name('edit');
            Route::put('/{role}', [RoleController::class,'update'])->name('update');
            Route::delete('/{role}', [RoleController::class,'destroy'])->name('destroy');
        });

        // مدیریت کامل پست‌ها برای ادمین
        Route::prefix('posts')->as('posts.')->group(function () {
            Route::get('/', [PostController::class, 'index'])->name('index');
            Route::get('/create', [PostController::class, 'create'])->name('create');
            Route::post('/', [PostController::class, 'store'])->name('store');
            Route::get('/{post}/edit', [PostController::class, 'edit'])->name('edit');
            Route::put('/{post}', [PostController::class, 'update'])->name('update');
            Route::delete('/{post}', [PostController::class, 'destroy'])->name('destroy');
        });

    });
});



Route::get('/debug-locale', function () {
    return [
        'current_locale' => app()->getLocale(),
        'fallback_locale' => config('app.fallback_locale'),
        'lang_path' => lang_path(),
        'fa_validation_exists' => file_exists(lang_path('fa/validation.php')),
        'en_validation_exists' => file_exists(lang_path('en/validation.php')),
        'available_locales' => ['en', 'fa'], // لیست زبان‌های موجود
        'translation_test' => trans('validation.required', ['attribute' => 'نام']),
    ];
});
