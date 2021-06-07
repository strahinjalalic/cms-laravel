<?php

use App\Http\Controllers\Blog\PostsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', 'WelcomeController@index')->name('welcome');
Route::get('/blog-posts/{post}', [PostsController::class, 'show'])->name('blogs.show'); //drugi nacin za pozivanje metoda
Route::get('/blog/category/{category}', [PostsController::class, 'category'])->name('blogs.category');
Route::get('/blog/tag/{tag}', [PostsController::class, 'tag'])->name('blogs.tag');

Route::middleware(['auth'])->group(function() {
    Route::resource('categories', 'CategoryController');
    Route::resource('posts', 'PostsController');
    Route::resource('tags', 'TagsController');
    Route::get('trashed', 'PostsController@trashed')->name('trashed');
    Route::post('restore/{post}', 'PostsController@restore')->name('posts.restore');
});

Route::middleware(['auth', 'admin'])->group(function() {
    Route::get('/users/profile', 'UsersController@edit')->name('users.edit-profile');
    Route::put('/user/update', 'UsersController@update')->name('users.update-profile');
    Route::get('/users', 'UsersController@index')->name('users.index');
    Route::post('/users/{user}/make-admin', 'UsersController@makeAdmin')->name('users.make-admin');
});


