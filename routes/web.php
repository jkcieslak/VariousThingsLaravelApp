<?php

use App\Http\Controllers\AoCController;
use App\Http\Controllers\CatFactController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Home Route
Route::get('/', [HomeController::class, 'home']);

//Advent of Code
Route::controller(AoCController::class)->name('aoc.')->prefix('aoc')->group(function () {
    Route::get('/index', 'index')->name('index');
    Route::get('/{year}/{day}/{puzzle}/{fetchFromAoC?}','puzzleAnswer')->name('puzzle');
});



//Ascii decoder
Route::get('/ascii', function () {
    return view('asciiDecoder');
});


//Rest

Route::get('/helloWorld', function () {
    return view('helloWorld');
});

Route::get('/login', function () {
    return view('welcome');
});

Route::get('/register', function () {
    return view('welcome');
});

Route::fallback(function() {
    return 'Ya lost, kid?';
});
