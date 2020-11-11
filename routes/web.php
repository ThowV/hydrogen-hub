<?php

use Illuminate\Support\Facades\Route;

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
    return view('layouts.dashboard');
});

Route::get('/dashboard', function () {
    return view('layouts.dashboard');
});

Route::get('/market', function () {
    return view('layouts.dashboard');
});

/*
Route::get('/company/', function () {
    return COMPANY PORTFOLIO
});

Route::get('/company/portfolio', function () {
    return COMPANY PORTFOLIO
});

Route::get('/company/overview', function () {
    return COMPANY OVERVIEW
});
 */

