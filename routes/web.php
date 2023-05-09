<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\TagsController;
use App\Http\Controllers\Dashboard\ArtistsController;
use App\Http\Controllers\Dashboard\AlbumsController;
use App\Http\Controllers\Dashboard\MusicController;
use App\Http\Controllers\Dashboard\ArticlesController;
use App\Http\Controllers\Dashboard\CommentsController;
use App\Http\Controllers\Dashboard\ProtectionsController;
use App\Http\Controllers\Dashboard\SliderController;
use App\Http\Controllers\Dashboard\UsersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[IndexController::class,'index'])->name('index');
Route::get('albums',[IndexController::class,'albums'])->name('albums');
Route::get('album/{album}',[IndexController::class,'album'])->name('album');
Route::get('blog',[IndexController::class,'blog'])->name('blog');
Route::get('article/{article}',[IndexController::class,'article'])->name('article');
Route::get('musics',[IndexController::class,'musics'])->name('musics');
Route::get('music/{music}',[IndexController::class,'music'])->name('music');
Route::get('register-login',[IndexController::class,'register_login'])->name('register_login')->middleware('guest');
Route::put('download-music/{music}',[IndexController::class,'download_music'])->name('download.music');
Route::post('comment-store/{content}',[IndexController::class,'commentStore'])->name('comment.store');
Auth::routes(['verify'=>true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth','verified'])->prefix('dashboard')->group(function (){
    Route::get('/',[App\Http\Controllers\Dashboard\IndexController::class,'index'])->name('dashboard.index');
    Route::resource('categories',CategoriesController::class)->except('show');
    Route::resource('tags',TagsController::class)->except('show');
    Route::resource('artists',ArtistsController::class)->except('show');
    Route::resource('albums',AlbumsController::class)->except('show');
    Route::resource('music',MusicController::class)->except('show');
    Route::resource('articles',ArticlesController::class)->except('show');
    Route::post('ckeditor/image-upload',[ArticlesController::class,'ckeditor_image_upload'])->name('ckeditor.image_upload');
    Route::put('access-or-cancel-article-moshtarak/{article}',[ArticlesController::class,'access_or_cancel_moshtarak'])->name('access_or_cancel.article_moshtarak');
    Route::resource('comments',CommentsController::class);
    Route::post('reply/{comment}',[CommentsController::class,'reply'])->name('comments.reply');
    Route::resource('protections',ProtectionsController::class)->except('show');
    Route::resource('slider',SliderController::class)->except('show');
    Route::resource('users',UsersController::class)->except(['index','create','store','show']);
    Route::put('delete-image-profile/{user}',[UsersController::class,'delete_image_profile'])->name('delete.image.profile');
});
