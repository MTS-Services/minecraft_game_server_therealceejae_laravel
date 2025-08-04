<?php

use Azuriom\Plugin\ServerListing\Controllers\Admin\AdminController;
use Azuriom\Plugin\ServerListing\Controllers\Admin\CategoryController;
use Azuriom\Plugin\ServerListing\Controllers\Admin\ServerListingController;
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
    Route::get('/servers', 'create')->name('create');
    Route::post('/servers', 'store')->name('create');
    Route::get('/servers/{server}', 'edit')->name('edit');
    Route::put('/servers/{server}', 'update')->name('edit');
    Route::delete('/servers/{server}', 'destroy')->name('destroy');
});
Route::controller(CategoryController::class)->name('categories.')->prefix('categories')->group(function () {
    Route::get('/index', 'index')->name('index');
    Route::get('/categories', 'create')->name('create');
    Route::post('/categories', 'store')->name('create');
    Route::get('/categories/{category}', 'edit')->name('edit');
    Route::put('/categories/{category}', 'update')->name('edit');
    Route::delete('/categories/{category}', 'destroy')->name('destroy');
});

