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

Route::get('/loan-details', [App\Http\Controllers\LoanDetailsController::class, 'index'])->middleware('auth');
Route::get('/emi-details', [App\Http\Controllers\EmiDetailsController::class, 'showEmiDetails'])->middleware('auth');
Route::get('/process-data', [App\Http\Controllers\EmiDetailsController::class, 'index'])->middleware('auth');
Route::post('/process-data', [App\Http\Controllers\EmiDetailsController::class, 'processData'])->middleware('auth');
