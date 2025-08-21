<?php

use Azuriom\Plugin\ServerListing\Controllers\Admin\ServerListingController;
use Azuriom\Plugin\ServerListing\Controllers\Admin\TagController;
use Azuriom\Plugin\ServerListing\Controllers\VoteManagementController;
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

Route::get('votes', [VoteManagementController::class, 'index'])->name('votes');
Route::get('votes/{server}', [VoteManagementController::class, 'show'])->name('votes.show');
Route::post('votes/{server}/test-votifier', [VoteManagementController::class, 'testVotifier'])->name('votes.test-votifier');
Route::post('votes/{vote}/resend', [VoteManagementController::class, 'resendVote'])->name('votes.resend');
Route::get('votes/{server}/export', [VoteManagementController::class, 'exportVotes'])->name('votes.export');
