<?php

use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\List_;
use App\Http\Controllers\Users;
use App\http\Controllers\Listings;
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

Route::get('/', function () {
    return view('welcome');
});


Route::group(["middleware" => "Auth"], function () {
    Route::get('addlisting', [Listings::class, 'addlisting']);
    Route::post('storelisting', [Listings::class, 'storelisting']);
    Route::get('delete/{id}', [Listings::class, 'delete']);
    Route::get('editlisting/{id}', [Listings::class, 'editlisting']);
    Route::post('updatelisting/{id}', [Listings::class, 'updatelisting']);
    Route::get('manage', [Listings::class, 'manage']);
});


Route::get('listings', [Listings::class, 'getAllListings']);
Route::get('listing/{id}', [Listings::class, 'getlisting']);
Route::get('logout', [Users::class, 'logout']);

Route::group(["middleware" => "guest"], function () {
    Route::get('register', [Users::class, 'register']);
    Route::Post('storeuser', [Users::class, 'storeUser']);
    Route::get('login', [Users::class, 'login'])->name('login');
    Route::Post('logincheck', [Users::class, 'logincheck']);
});

// Route::get('logout', [Listings::class, 'addListing']);

