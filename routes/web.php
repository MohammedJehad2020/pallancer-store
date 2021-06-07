<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\UserController;
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
    return view('front.index');
});

// route fore registration page
Route::get('/register', [CategoriesController::class, 'register'])->name('register');
Route::post('/', [CategoriesController::class, 'infoStore'])->name('infoStore');


Route::namespace('Admin')
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {

        Route::group([
            'prefix' => 'categories',
            'as' => 'categories.',
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

        Route::resource('products', 'ProductsController');
    });

// Route::resource('admin/categories', 'Admin\CategoriesController');


Route::get('admin/users/{id}', [UserController::class, 'show'])->name('users.show');



//regular Excepression For 
Route::get('regexp', function () {

    $test = '059-1214567';
    $exp = '/^(059|056)\-?([0-9]{7})$/';

    $email = 'name.last-nam_12@domain.com';
    $pattern = '/[a-zA-Z0-9]+[a-zA-Z0-9\.\-_]*@[a-zA-Z0-9\.\-]*[a-zA-Z0-9]+$/';

    preg_match_all($pattern, $email, $matches);
    dd($matches);
});
