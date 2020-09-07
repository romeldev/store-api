<?php

use Illuminate\Support\Facades\Route;


Route::get('/upload', function() {
    return view('galery');
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/passport', 'HomeController@passport')->name('passport');