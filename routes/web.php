<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MessageController;

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

Route::get('/', [ProductController::class, 'index'])//スラッシュがあったらインデックスに行くよ
    ->name('root');

Route::get('/welcome', function () {
    return view('welcome');
})->middleware('guest')
    ->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('masa/register', function () {
    return view('masa.register');
})->middleware('guest')
    ->name('masa.register');


Route::resource('products', ProductController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('can:masa');

Route::resource('products', ProductController::class)
    ->only(['index']);
    
    
Route::resource('products', ProductController::class)
    ->only(['show', 'index'])
    ->middleware('auth');

Route::resource('products.messages', MessageController::class)
    ->only(['store', 'destroy'])
    ->middleware('auth');

// Route::resource('products.register', ProductController::class)
//     ->only(['update'])
//     ->middleware('can:user');

Route::patch('products/{product}/register', [ProductController::class, 'approval'])
    ->name('products.register.approval')
    ->middleware('can:user');

// Route::get('products/{product}/register', [ProductController::class, 'approval'])
//     ->name('products.register.approval')
//     ->middleware('can:user');


