<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarketController;
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


Route::get('/login',    \App\Http\Livewire\LoginComponent::class)->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('/',             [DashboardController::class, 'show'])->name('home');
    Route::get('/dashboard',    [DashboardController::class, 'show']);
    Route::get('/market',       [MarketController::class, 'show']);
});


/*
Route::get('/company/',         ...);
Route::get('/company/portfolio, ...);
Route::get('/company/overview', ...);
 */

