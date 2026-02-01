<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth'); // فقط کاربران وارد شده


Route::prefix('posts')
     ->as('posts.')
     ->group(function () {
         Route::get('/', [PostController::class, 'index'])->name('index');
         Route::get('/create', [PostController::class, 'create'])->name('create');
         Route::post('/', [PostController::class, 'store'])->name('store');
         Route::get('/{post}/edit', [PostController::class, 'edit'])->name('edit');
         Route::put('/{post}', [PostController::class, 'update'])->name('update');
         Route::delete('/{post}', [PostController::class, 'destroy'])->name('destroy');
     });
