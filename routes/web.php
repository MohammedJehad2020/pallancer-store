<?php

use App\Http\Controllers\Admin\CategoriesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Models\Category;

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

Route::get('/', function () {
    return view('welcome');
});

// route fore registration page
Route::get('/register', [CategoriesController::class, 'register'])->name('register');
Route::post('/', [CategoriesController::class, 'infoStore'])->name('infoStore');



Route::group([
    'prefix' => 'admin/categories',
    'namespace' => 'Admin',
    'as' => 'admin.categories.',
], function () {
    // admin.categories.index
    Route::get('/', 'CategoriesController@index')->name('index');
    Route::get('/product', 'CategoriesController@product')->name('product');
    Route::get('/dashboard', 'CategoriesController@dashboard')->name('dashboard');
    // admin.categories.create
    Route::get('/create', 'CategoriesController@create')->name('create');
    // admin.categories.show
    Route::get('/{id}', 'CategoriesController@show')->name('show');
     Route::post('/', [CategoriesController::class, 'store'])->name('store');
     Route::get('/{id}/edit', [CategoriesController::class, 'edit'])->name('edit');
     Route::put('/{id}', [CategoriesController::class, 'update'])->name('update');
     Route::delete('/{id}', [CategoriesController::class, 'destroy'])->name('destroy');
    
});

// Route::resource('admin/categories', 'Admin\CategoriesController');
