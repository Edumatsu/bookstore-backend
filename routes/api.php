<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::prefix('books')->controller(BookController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/', 'store');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});

/*Route::group(['prefix' => 'autores'], function() {
    Route::get('/', 'AutorController@index');
    Route::get('/{autor}', 'AutorController@show');
    Route::post('/', 'AutorController@store');
    Route::put('/{autor}', 'AutorController@update');
    Route::delete('/{autor}', 'AutorController@destroy');
});

Route::group(['prefix' => 'assuntos'], function() {
    Route::get('/', 'AssuntoController@index');
    Route::get('/{assunto}', 'AssuntoController@show');
    Route::post('/', 'AssuntoController@store');
    Route::put('/{assunto}', 'AssuntoController@update');
    Route::delete('/{assunto}', 'AssuntoController@destroy');
});

Route::group(['prefix' => 'relatorios'], function() {
    Route::get('/dashboard', 'RelatorioController@dashboard');
    Route::get('/relatorio', 'RelatorioController@report');
});*/