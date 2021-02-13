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


// Home page route
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

// Show list of products
Route::post('/products/list', [App\Http\Controllers\ProductController::class, 'list']);

// Show list of categories
Route::post('/categories/list', [App\Http\Controllers\CategoryController::class, 'list']);
