<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('/vehicles')->name('vehicles.')->middleware('auth')->group(function() {
    Route::get('', [App\Http\Controllers\VehiclesController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\VehiclesController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [App\Http\Controllers\VehiclesController::class, 'edit'])->name('edit');

    Route::post('/save', [App\Http\Controllers\VehiclesController::class, 'save'])->name('save');
    Route::delete('/delete/{id}', [App\Http\Controllers\VehiclesController::class, 'delete'])->name('delete');
});