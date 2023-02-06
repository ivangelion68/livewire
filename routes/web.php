<?php

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

Route::get('/', App\Http\Livewire\Articles::class)->name('article.index');
Route::get('/blog/crear', App\Http\Livewire\ArticleForm::class)->name('article.create');
Route::get('/blog/{article}', App\Http\Livewire\ArticleShow::class)->name('article.show');
