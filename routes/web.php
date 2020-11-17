<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\RegistrationRequestController;
use App\Http\Controllers\WelcomeMessageController;
use App\Http\Livewire\Company\RegisterComponent;
use App\Http\Livewire\LoginComponent;
use Illuminate\Support\Facades\Route;
use Spatie\WelcomeNotification\WelcomesNewUsers;

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


Route::get('/login',                                         LoginComponent::class)->name('login');
Route::get('/register' ,                                     RegisterComponent::class);

Route::group(['middleware' =>                                           ['web', WelcomesNewUsers::class,]], function () {
    Route::get('welcome/{user}',                                    [WelcomeMessageController::class, 'showWelcomeForm'])->name('welcome');
    Route::post('welcome/{user}',                                   [WelcomeMessageController::class, 'savePassword'])->name('welcome.post');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/',                                                 [DashboardController::class, 'show'])->name('home');
    Route::get('/dashboard',                                        [DashboardController::class, 'show'])->name('dashboard');
    Route::get('/market',                                           [MarketController::class, 'show'])->name('market');
    Route::get('/company_request/{registration_request}/accept',    [RegistrationRequestController::class, 'accept'])->name('request.accept');
    Route::get('/company_request/{registration_request}/deny',      [RegistrationRequestController::class, 'deny'])->name('request.deny');
});


/*
Route::get('/company/',         ...);
Route::get('/company/portfolio, ...);
Route::get('/company/overview', ...);
 */

