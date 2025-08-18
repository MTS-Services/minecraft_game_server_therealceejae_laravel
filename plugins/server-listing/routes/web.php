<?php

use Azuriom\Plugin\ServerListing\Controllers\CheckConnectionController;
use Azuriom\Plugin\ServerListing\Controllers\ServerListingController;
// use Azuriom\Plugin\ServerListing\Controllers\ServerListingHomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your plugin. These
| routes are loaded by the RouteServiceProvider of your plugin within
| a group which contains the "web" middleware group and your plugin name
| as prefix. Now create something great!
|
*/

// Route::get('/', [ServerListingHomeController::class, 'index']);

Route::get('/server/{slug}', [ServerListingController::class, 'details'])->name('details');

Route::post('/check-connection', [CheckConnectionController::class, 'checkConnection'])->name('check-connection');
// Route::get('/submission', [ServerListingController::class, 'submission'])->name('submission')->middleware('auth:web');
Route::controller(ServerListingController::class)->middleware('auth:web')->group(function () {
    Route::get('/submission', 'submission')->name('submission');
    Route::post('/store', 'store')->name('submission.store');
    Route::get('/dashboard', 'userDashboard')->name('user-dashboard');
    Route::get('/server-list', 'serverList')->name('list');
    Route::get('/bidding-info', 'biddingInfo')->name('bidding-info');
});
