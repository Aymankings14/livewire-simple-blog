<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
})->middleware('guest');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware'=>'auth'],function (){
/*
 *
 * App without Livewire
 *
 * */
    Route::resource('/posts',\App\Http\Controllers\PostController::class);
/*
 *
 *  App With Livewire Component
 *
 *  */
    Route::get('/livewire/posts', \App\Livewire\Posts::class)->name('index.post');
    Route::get('/livewire/posts/create', \App\Livewire\CreatePost::class)->name('postCreate');
    Route::get('/livewire/posts/{post_id}/edit', \App\Livewire\EditPost::class)->name('postEdit');
    Route::get('/livewire/posts/{post_id}', \App\Livewire\ShowPost::class)->name('postShow');
});
