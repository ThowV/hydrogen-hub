<?php

use App\Http\Controllers\DashboardController;
use App\Http\Livewire\LoginComponent;
use App\Http\Livewire\MarketComponent;
use App\Http\Controllers\RegistrationRequestController;
use App\Http\Livewire\Company\RegisterComponent;
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

Route::get('/register', RegisterComponent::class);

Route::get('/company_request/{registration_request}/accept',  [RegistrationRequestController::class, 'accept'])->name('request.accept');
Route::get('/company_request/{registration_request}/deny',    [RegistrationRequestController::class, 'deny'])->name('request.deny');

Route::get('/login',    LoginComponent::class)->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('/',             [DashboardController::class, 'show'])->name('home');
    Route::get('/dashboard',    [DashboardController::class, 'show']);
    Route::get('/market',       MarketComponent::class);
});

