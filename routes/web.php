<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth','verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::prefix('roles')->as('roles.')->group(function () {
        Route::get('/', [RoleController::class,'index'])->name('index');
        Route::get('/create', [RoleController::class,'create'])->name('create');
        Route::post('/', [RoleController::class,'store'])->name('store');
        Route::get('/{role}/edit', [RoleController::class,'edit'])->name('edit');
        Route::put('/{role}', [RoleController::class,'update'])->name('update');
        Route::delete('/{role}', [RoleController::class,'delete'])->name('destroy');
    });

    Route::prefix('posts')
         ->as('posts.')
         ->middleware('role:super-admin')
         ->group(function () {
             Route::get('/', [PostController::class, 'index'])->name('index');
             Route::get('/{post}/show', [PostController::class, 'show'])->name('show');
             Route::get('/create', [PostController::class, 'create'])->name('create');
             Route::post('/', [PostController::class, 'store'])->name('store');
             Route::get('/{post}/edit', [PostController::class, 'edit'])->name('edit');
             Route::put('/{post}', [PostController::class, 'update'])->name('update');
             Route::delete('/{post}', [PostController::class, 'destroy'])->name('destroy');
         });

});
