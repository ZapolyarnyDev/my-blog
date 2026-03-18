<?php

use App\Http\Controllers\admin\PostController;
use App\Http\Controllers\PostFeedController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    Route::get('/posts/admin', [PostFeedController::class, 'adminPosts'])
        ->name('posts.admin.index');

    Route::prefix('/admin')->middleware(['role:admin,editor'])->group(function () {
        Route::prefix('posts')->name('admin.')->group(function () {
            Route::get('/', [PostController::class, 'index'])->name('post.index');
            Route::get('/create', [PostController::class, 'create'])->name('post.create');
            Route::post('/create', [PostController::class, 'store'])->name('post.store');
            Route::get('/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
            Route::put('/{post}', [PostController::class, 'update'])->name('post.update');
            Route::get('/{post}', [PostController::class, 'show'])->name('post.show');
            Route::delete('/{post}', [PostController::class, 'destroy'])->name('post.delete');
        });
    });

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});


require __DIR__.'/auth.php';
