<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Subdomain;
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

Route::domain(env('APP_PLAIN_URL'))->group(function () {

    Route::middleware('auth')->get('/', [HomeController::class, 'index'])->name('home');

    Route::middleware('guest')->group(function () {

        Route::prefix('customers')->as('customers.')->group(function () {
            Route::get('register', [CustomerController::class, 'register'])->name('register.index');
            Route::post('register', [CustomerController::class, 'registerPost'])->name('register.post');
        });

        Route::get('login', [AuthController::class, 'login'])->name('login.index');
        Route::post('login', [AuthController::class, 'loginPost'])->name('login.post');
        Route::get('register', [AuthController::class, 'register'])->name('register.index');
        Route::post('register', [AuthController::class, 'registerPost'])->name('register.post');

    });

    Route::middleware('auth')->as('admin.')->prefix('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::patch('tables-to-exclude', [DashboardController::class, 'update'])->name('tables-to-exclude.update');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});

Route::domain('{account}.'.env('APP_PLAIN_URL'))
    ->as('subdomain.')
    ->group(function () {
        Route::middleware('subdomain-guest')->group(function () {
            Route::get('login', [Subdomain\AuthController::class, 'login'])->name('login.index');
            Route::post('login', [Subdomain\AuthController::class, 'loginPost'])->name('login.post');
        });

        Route::middleware('auth:subdomain')->group(function () {
            Route::get('/', [Subdomain\HomeController::class, 'index'])->name('index');
            Route::post('/logout', [Subdomain\AuthController::class, 'logout'])->name('logout');
        });
    });
