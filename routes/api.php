<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('/categories', 'CategoryController');
Route::resource('/tags', 'TagController');
Route::resource('/products', 'ProductController');
Route::get('/products/{product_id}/photos', 'ProductController@photos');


Route::get('/catalog', 'CatalogController@index');
Route::get('/catalog/{product}', 'CatalogController@show');
