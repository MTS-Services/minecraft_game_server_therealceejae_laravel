<?php

use Azuriom\Plugin\ServerListing\Controllers\Admin\ServerListingController;
use Azuriom\Plugin\ServerListing\Controllers\Admin\TagController;
use Azuriom\Plugin\ServerListing\Controllers\Admin\Vote\RewardController;
use Azuriom\Plugin\ServerListing\Controllers\Admin\Vote\SettingController;
use Azuriom\Plugin\ServerListing\Controllers\Admin\Vote\SiteController;
use Azuriom\Plugin\ServerListing\Controllers\Admin\Vote\VoteController;
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

Route::controller(ServerListingController::class)->name('servers.')->group(function () {
    Route::get('/index', 'index')->name('index');
    Route::post('/servers/update-order', 'updateOrder')->name('update-order');
    Route::get('/servers', 'create')->name('create');
    Route::post('/servers', 'store')->name('create');
    Route::get('/servers/{server}', 'edit')->name('edit');
    Route::put('/servers/{server}', 'update')->name('edit');
    Route::delete('/servers/{server}', 'destroy')->name('destroy');
});


Route::controller(TagController::class)->name('tags.')->prefix('tags')->group(function () {
    Route::get('/index', 'index')->name('index');
    Route::post('/tags/update-order', 'updateOrder')->name('update-order');
    Route::get('/tags', 'create')->name('create');
    Route::post('/tags', action: 'store')->name('create');
    Route::get('/tags/{tag}', 'edit')->name('edit');
    Route::put('/tags/{tag}', 'update')->name('edit');
    Route::delete('/tags/{tag}', 'destroy')->name('destroy');
});

Route::prefix('vote')->name('vote.')->middleware('can:server-listing.admin')->group(function () {
    Route::get('/settings', [SettingController::class, 'show'])->name('settings');
    Route::post('/settings', [SettingController::class, 'save'])->name('settings.save');

    Route::get('sites/verification', [SiteController::class, 'verificationForUrl'])->name('sites.verification');

    Route::resource('sites', SiteController::class)->except('show');
    Route::resource('rewards', RewardController::class)->except('show');

    Route::get('votes', [VoteController::class, 'index'])->name('votes.index');
});
