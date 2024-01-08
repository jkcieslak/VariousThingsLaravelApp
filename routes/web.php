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
Route::get('/aoc/{year}/{day}/{puzzle}/{fetchFromAoC?}', [AoCController::class, 'puzzleAnswer']);

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
