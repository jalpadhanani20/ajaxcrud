<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
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

Route::namespace('Auth')->group(function () {
    Route::get('login', 'LoginController@index')->name('login');
    Route::post('post-login', 'LoginController@postLogin')->name('login.post'); 
    Route::get('registration', 'LoginController@registration')->name('register');
    Route::post('post-registration', 'LoginController@postRegistration')->name('register.post'); 
    Route::get('dashboard', 'LoginController@dashboard'); 
    Route::get('logout', 'LoginController@logout')->name('logout');
    
});

Route::group(['middleware' => ['auth']], function() {
    Route::get('ajax-product-crud', 'ProductController@index')->name('ajax-product-crud');
    Route::post('add-update-product', 'ProductController@store');
    Route::post('edit-product', 'ProductController@edit');
    Route::post('delete-product', 'ProductController@destroy');
});    



