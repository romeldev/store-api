<?php

use Illuminate\Support\Facades\Route;


Route::get('/upload', function() {
    return view('galery');
});

Route::get('/', function () {
    return view('welcome');
});
