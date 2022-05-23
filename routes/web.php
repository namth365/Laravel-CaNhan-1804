<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

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
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'user', 'middleware' =>[ 'auth']], function () {

    Route::get('', [UserController::class, 'index'])->name('users.index')->middleware('check.permission:user-list');
    Route::get('create', [UserController::class, 'create'])->name('users.create')->middleware('check.permission:user-create');
    Route::post('store', [UserController::class, 'store'])->name('users.store')->middleware('check.permission:user-create');
    Route::get('edit/{id}', [UserController::class, 'edit'])->name('users.edit')->middleware('check.permission:user-edit');
    Route::put('update/{id}', [UserController::class, 'update'])->name('users.update')->middleware('check.permission:user-edit');
    Route::delete('delete/{id}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('check.permission:user-delete');
});
Route::group(['prefix' => 'role', 'middleware' =>'auth'], function () {

    Route::get('', [RoleController::class, 'index'])->name('roles.index')->middleware('check.permission:role-list');
    Route::get('create', [RoleController::class, 'create'])->name('roles.create')->middleware('check.permission:role-create');
    Route::post('store', [RoleController::class, 'store'])->name('roles.store')->middleware('check.permission:role-create');
    Route::get('edit/{id}', [RoleController::class, 'edit'])->name('roles.edit')->middleware('check.permission:role-edit');
    Route::put('update/{id}', [RoleController::class, 'update'])->name('roles.update')->middleware('check.permission:role-edit');
    Route::delete('delete/{id}', [RoleController::class, 'destroy'])->name('roles.destroy')->middleware('check.permission:role-delete');
});
Route::group(['prefix' => 'category', 'middleware' => 'auth'], function () {

    Route::get('', [CategoryController::class, 'index'])->name('categories.index')->middleware('check.permission:category-list');
    Route::get('create', [CategoryController::class, 'create'])->name('categories.create')->middleware('check.permission:category-create');
    Route::post('store', [CategoryController::class, 'store'])->name('categories.store')->middleware('check.permission:category-create');
    Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit')->middleware('check.permission:category-edit');
    Route::put('update/{id}', [CategoryController::class, 'update'])->name('categories.update')->middleware('check.permission:category-edit');
    Route::delete('delete/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy')->middleware('check.permission:category-delete');
});
Route::group(['prefix' => 'product', 'middleware' => 'auth'], function () {

    Route::get('', [ProductController::class, 'index'])->name('products.index')->middleware('check.permission:product-list');
    Route::get('create', [ProductController::class, 'create'])->name('products.create')->middleware('check.permission:product-create');
    Route::post('store', [ProductController::class, 'store'])->name('products.store')->middleware('check.permission:product-create');
    Route::get('edit/{id}', [ProductController::class, 'edit'])->name('products.edit')->middleware('check.permission:product-edit');
    Route::post('update/{id}', [ProductController::class, 'update'])->name('products.update')->middleware('check.permission:product-edit');
    Route::get('delete/{id}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('check.permission:product-delete');
});
