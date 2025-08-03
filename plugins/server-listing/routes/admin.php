<?php

use Azuriom\Plugin\ServerListing\Controllers\Admin\AdminController;
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

Route::get('/index', [ServerListingController::class, 'index'])->name('servers.index');
Route::get('/servers', [ServerListingController::class, 'create'])->name('servers.create');
Route::post('/servers', [ServerListingController::class, 'store'])->name('servers.create');
Route::get('/servers/{server}', [ServerListingController::class, 'edit'])->name('servers.edit');
Route::put('/servers/{server}', [ServerListingController::class, 'update'])->name('servers.edit');
Route::delete('/servers/{server}', [ServerListingController::class, 'destroy'])->name('servers.destroy');
