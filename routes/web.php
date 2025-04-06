<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard'); 
});

Route::get('/barang', function () {
    return view('manajemen_barang.index'); 
});


