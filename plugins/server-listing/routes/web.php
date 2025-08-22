<?php

use Azuriom\Plugin\ServerListing\Controllers\BidController;
use Azuriom\Plugin\ServerListing\Controllers\CheckConnectionController;
use Azuriom\Plugin\ServerListing\Controllers\PaymentController;
use Azuriom\Plugin\ServerListing\Controllers\ServerListingController;
use Azuriom\Plugin\ServerListing\Controllers\VoteController;
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
Route::get('/server/favorite/{slug}', [ServerListingController::class, 'favorite'])->name('favorite')->middleware('auth:web');
// Voting Routes
// Route::controller(VoteController::class)->prefix('vote')->name('vote.')->group(function () {
//     Route::get('/{slug}',  'index')->name('index');
//     Route::post('/{slug}', 'store')->name('store');
// });

Route::post('/check-connection', [CheckConnectionController::class, 'checkConnection'])->name('check-connection')->middleware('auth:web');
// Route::get('/submission', [ServerListingController::class, 'submission'])->name('submission')->middleware('auth:web');
Route::controller(ServerListingController::class)->middleware('auth:web')->group(function () {
    Route::get('/submission', 'submission')->name('submission');
    Route::post('/store', 'store')->name('submission.store');
    Route::get('/dashboard', 'userDashboard')->name('user-dashboard');
    Route::get('/server-list', 'serverList')->name('list');
});
Route::controller(BidController::class)->middleware('auth:web')->name('bids.')->group(function () {
    Route::get('/bidding/{slug}', 'biddingInfo')->name('bidding');
    Route::post('/place-bid/{slug}', 'placeBid')->name('place-bid');
});

Route::controller(PaymentController::class)->prefix('payments')->name('payments.')->group(function () {
    Route::post('/payment/{encryptedId}', 'payment')->name('payment');
    Route::post('/{gateway:type}/pay', 'pay')->name('pay');
});

Route::get('{slug}/vote', [VoteController::class, 'showVotePage'])->name('vote');
Route::post('{slug}/vote', [VoteController::class, 'submitVote'])->name('vote.submit');
Route::post('{slug}/vote/status', [VoteController::class, 'checkVoteStatus'])->name('vote.status');
