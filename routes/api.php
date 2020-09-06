<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/categories', 'CategoryController');
Route::resource('/tags', 'TagController');
Route::resource('/products', 'ProductController');
Route::get('/products/{product_id}/photos', 'ProductController@photos');
Route::get('/catalog', 'CatalogController@index');
Route::get('/catalog/{product}', 'CatalogController@show');
Route::get('/catalog/{product}/related', 'CatalogController@related');
Route::get('/repository', 'RepositoryController@index');
