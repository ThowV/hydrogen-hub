<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\RegistrationRequestController;
use App\Http\Controllers\WelcomeMessageController;
use App\Http\Livewire\Components\Company\RegisterComponent;
use App\Http\Livewire\Components\Login\LoginComponent;
use App\Http\Livewire\Components\Market\MarketComponent;
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

Route::get('/Login',                                          LoginComponent::class)->name('Login');
Route::get('/register',                                       RegisterComponent::class);

Route::get('/Login',                                          LoginComponent::class)->name('Login');
Route::get('/register',                                       RegisterComponent::class)->name('company.register');

Route::group(['middleware' =>                                           ['web', WelcomesNewUsers::class,]], function () {
    Route::get('welcome/{user}',                                    [WelcomeMessageController::class, 'showWelcomeForm'])->name('welcome');
    Route::post('welcome/{user}',                                   [WelcomeMessageController::class, 'savePassword'])->name('welcome.post');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/',                                                 [DashboardController::class, 'show'])->name('home');
    Route::get('/dashboard',                                        [DashboardController::class, 'show'])->name('dashboard');
    Route::get('/market',                                     MarketComponent::class)->name('market');
    Route::get('/admin',                                            [AdminController::class, 'index'])->name('admin');
    Route::get('/company',                                          [CompanyController::class, 'index'])->name('company');
    Route::get('/company/portfolio',                                [CompanyController::class, 'portfolio'])->name('company.portfolio');
    Route::get('/company/employees',                                [CompanyController::class, 'overview'])->name('company.overview');
    Route::get('/company_request/{registration_request}/accept',    [RegistrationRequestController::class, 'accept'])->name('request.accept');
    Route::get('/company_request/{registration_request}/deny',      [RegistrationRequestController::class, 'deny'])->name('request.deny');


    Route::resource('employees',                          EmployeesController::class);
});

