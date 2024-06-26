<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;

/**
 * Admin Controllers
 */
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\CategoriesController;


Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    Route::get('/', [HomeController::class, 'index'])->name('index'); //homepage
    Route::get('/people', [HomeController::class, 'search'])->name('search'); // 1

    /**
     *  Open the create post page (create.blade.php)
     */
    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');

    /**
     * Store the post details into posts table
     */
    Route::post('/post/store', [PostController::class, 'store'])->name('post.store');

    /**
     * Open the show post page
     */
    Route::get('/post/{id}/show', [PostController::class, 'show'])->name('post.show');

    /**
     * Route to open the edit page (edit.blade.php)
     */
    Route::get('/post/{id}/edit', [PostController::class, 'edit'])->name('post.edit');

    /**
     * Route use to perform the actual update
     */
    Route::patch('/post/{id}/update', [PostController::class, 'update'])->name('post.update');

    /**
     * Route to delete a post
     */
    Route::delete('/post/{id}/destroy', [PostController::class, 'destroy'])->name('post.destroy');


    /**
     * Routes related to comments
     */
    Route::post('/comment/{post_id}/store', [CommentController::class, 'store'])->name('comment.store');
    Route::delete('/comment/{id}/destroy', [CommentController::class, 'destroy'])->name('comment.destroy');

    /**
     * Routes related for user profile
     */
    Route::get('/profile/{id}/show}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/{id}/followers', [ProfileController::class, 'followers'])->name('profile.followers');
    Route::get('/profile/{id}/following', [ProfileController::class, 'following'])->name('profile.following');

    /**
     * Routes related to Likes
     */
    Route::post('/like/{post_id}/store', [LikeController::class, 'store'])->name('like.store');
    Route::delete('/like/{post_id}/destroy', [LikeController::class, 'destroy'])->name('like.destroy');

    /**
     * Routes related to follow/unfollow
     */
    Route::post('/follow/{user_id}/store', [FollowController::class, 'store'])->name('follow.store');
    Route::delete('/follow/{user_id}/destroy', [FollowController::class, 'destroy'])->name('follow.destroy');

    
    /**
     * Routes related to Admin Dashboard
     */
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function(){
        # Users
        Route::get('/users', [UsersController::class, 'index'])->name('users'); //admin.users
        Route::delete('/users/{id}/deactivate', [UsersController::class, 'deactivate'])->name('users.deactivate'); //admin.users.deactivate
        Route::patch('/users/{id}/activate', [UsersController::class, 'activate'])->name('users.activate'); //admin.users.activate

        # Posts
        Route::get('/posts', [PostsController::class, 'index'])->name('posts'); //admin.posts
        Route::delete('/post/{id}/hide', [PostsController::class, 'hide'])->name('posts.hide'); //admin.posts.hide
        Route::patch('/post/{id}/unhide', [PostsController::class, 'unhide'])->name('posts.unhide'); //admin.posts.unhide

        # Categories
        Route::get('/categories', [CategoriesController::class, 'index'])->name('categories'); //admin.categories
        Route::post('/categories/store', [CategoriesController::class, 'store'])->name('categories.store');
        Route::patch('/categories/{id}/update', [CategoriesController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{id}/destroy', [CategoriesController::class, 'destroy'])->name('categories.destroy');

    });

});

