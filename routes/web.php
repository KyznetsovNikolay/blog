<?php

use App\Http\Controllers\Actions\CreateArticleAction;
use App\Http\Controllers\Actions\CreateCommentAction;
use App\Http\Controllers\Actions\IndexArticleAction;
use App\Http\Controllers\Actions\ViewArticleAction;
use Illuminate\Support\Facades\Route;

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

Route::match(['get', 'post'],'/', IndexArticleAction::class)->name('articles');
Route::match(['get', 'post'], '/article/create', CreateArticleAction::class)->name('article.create');
Route::get( '/article/view/{id}', ViewArticleAction::class)->name('article.view');
Route::post( '/comment/{articleId}', CreateCommentAction::class)->name('comment.create');
