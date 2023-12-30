<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\SubjectController;

Route::prefix('books')->controller(BookController::class)->group(
    function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    }
);

Route::prefix('authors')->controller(AuthorController::class)->group(
    function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    }
);


Route::prefix('subjects')->controller(SubjectController::class)->group(
    function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    }
);

/*Route::group(['prefix' => 'relatorios'], function() {
    Route::get('/dashboard', 'RelatorioController@dashboard');
    Route::get('/relatorio', 'RelatorioController@report');
});*/